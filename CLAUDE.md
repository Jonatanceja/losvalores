# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A [Kirby CMS](https://getkirby.com) 5 site built on the **beebmx/kirby-starterkit**. Unlike vanilla Kirby, this flavor uses **Laravel Blade** for templates (via `beebmx/kirby-blade`) and a `.env`-based config layer (via `beebmx/kirby-env`). PHP 8.3+ is required. There is no traditional database-backed model layer — content lives as flat text files under `content/`.

## Common commands

Frontend assets (Vite — Tailwind 4, Alpine, Vue, axios):
- `npm run dev` — Vite dev server with HMR (writes `public/hot`)
- `npm run build` (aliases: `prod`, `production`) — production build to `public/build`

Panel plugin (`site/plugins/app`, built separately with kirbyup, Vue 2):
- `npm run app-dev` — watch/rebuild the Panel plugin
- `npm run app` — one-off Panel plugin build
- `npm run app-setup` — install the plugin's own deps + build

PHP tests (Pest 4):
- `composer test` — the canonical way to run tests. It runs `php tests/helpers.php` **first**, then `vendor/bin/pest`.
- Single test: `vendor/bin/pest --filter=<name>` (run `php tests/helpers.php` once first if tests haven't been run yet — see gotcha below)

Formatting:
- `vendor/bin/pint` — PHP code style (Laravel Pint; excludes vendored plugins, see `pint.json`)
- `npx prettier --write .` — JS/CSS/Blade (uses `@shufo/prettier-plugin-blade` + tailwind plugin)

## Test gotcha

Kirby's `vendor/getkirby/cms/config/helpers.php` defines `dump()` and `e()`, which collide with functions PHPUnit/Pest pull in. `tests/helpers.php` **patches the vendored file in place**, renaming those to `__dump`/`__e`. This must run before Pest boots — that's why `composer test` chains it. After a fresh `composer install`, run `php tests/helpers.php` before invoking Pest directly.

## Architecture

**Config is split, not monolithic.** `site/config/config.php` is the entry point: it loads `.env` via `KirbyEnv::load()`, sets the cookie key, then `require`s one file per concern (`app.php`, `cache.php`, `email.php`, `hooks.php`, `routes.php`, `tasks.php`, plugin-namespaced configs like `beebmx.kirby-blade`, etc.). To change a Kirby option, edit the relevant per-concern file rather than `config.php`. All environment-specific values come through the `env()` helper — never hardcode; add to `.env` / `.env.example`.

**Templating is Blade, with a component layout.** Page templates live in `site/templates/` as `*.blade.php`. They wrap content in `<x-layout>`, which resolves to `App\View\Components\Layout` (`app/View/Components/Layout.php`, PSR-4 `App\` → `app/`), rendering `site/templates/layout/index.blade.php`. That layout file conditionally injects Vite assets only when a build manifest or `hot` file exists. Compiled Blade views are cached in `storage/views/`. Plain `.php` templates still work and Blade takes precedence when both exist for a page — but don't keep both; use `.blade.php` for all templates.

**Blade components** follow a strict two-file split — keep field-reading logic out of the markup. A class `App\View\Components\<Name>` (`app/View/Components/<Name>.php`) reads the Kirby page fields in `render()` and passes them to a view under `site/templates/components/<name>.blade.php`; that view is markup only. Component classes default their `?Page $page` constructor arg to the `page()` helper, so templates invoke them bare (e.g. `<x-hero />`) — no props threaded through. Example: `home.blade.php` is just `<x-layout><x-hero /></x-layout>`; `Hero.php` maps blueprint fields (`logo`, `bottle`, `bottleName`, `heroText`, `signature`, `background`, `illustration`) to view data. Content lives in the Panel (the page's blueprint), structure/design in the `.blade.php`, which-fields-load in the class. The view path root is `site/templates/`, so `view('components.hero')` → `site/templates/components/hero.blade.php` (same resolution as `view('layout.index')`).

**Static assets & CSS `url()` gotcha.** `laravel-vite-plugin` sets `publicDir: false`, so the Vite **dev server does not serve `public/`**. In dev, `resources/css/app.css` is served from the Vite origin (`public/hot` holds its URL), and any `url('/images/…')` inside that CSS resolves against the *Vite* origin → **404**. So CSS that references files in `public/` (e.g. the site background) must **not** live in the bundled CSS. Put it in an inline `<style>` in `layout/index.blade.php` (or another template served by the site origin) so `/images/…` resolves against the site and works in both dev and production. This is exactly how the site-wide repeating background is wired: an inline `<style>` on `body` using `image-set()` to prefer `background.webp` with a `background.png` fallback (both in `public/images/`). Ship raster images as both PNG and WebP (`cwebp -q 82 in.png -o out.webp`) and select via `image-set()`.

**Fonts** follow the same rule. Font files live in `public/fonts/`. The `@font-face` (with its `url('/fonts/…')`) is declared in an **inline `<style>` in `layout/index.blade.php`** — never in `app.css`, or the dev server 404s the font. To expose it as a Tailwind utility, add only a `--font-<name>` token under `@theme` in `app.css` (a family-name mapping with no `url()`, so it's safe in bundled CSS) and use the generated `font-<name>` class. Example: the nav uses `font-elzevir` → `--font-elzevir: '1669 Elzevir W01', …` in `@theme`, with the matching `@font-face` inline in the layout. URL-encode spaces in filenames (`%20`). Single-style display faces are declared `font-style: normal` so the class alone renders them (no `italic` utility, no browser synthesis).

**Custom Blade directives/conditionals** are registered in `site/config/blade.php` — e.g. `@env`, `@local`, `@production`, `@analytics`, and a `@ray` directive. These key off `KIRBY_ENV`.

**Two distinct JS build pipelines** — don't conflate them:
- Site frontend: `resources/js` + `resources/css`, bundled by Vite (root `vite.config.js`, `@` aliases `resources/js`).
- Panel (admin) plugin: `site/plugins/app/`, a Vue 2 plugin bundled by **kirbyup** with its own `package.json`. Panel UI extensions (blocks, fields, Vue components) go here.

**Multi-language** is enabled (`KIRBY_LANGUAGES=true`; the flag is read in `config.php`). Languages are defined in `site/languages/*.php`: **English is the default and lives at the root `/`** (`en.php`, `default => true`); **Spanish lives under `/es`** (`es.php`). Consequence for content: every content file **must** carry a language suffix — `home.en.txt` / `home.es.txt`, `site.en.txt` / `site.es.txt`, etc. A page's `Uuid` is shared across its translations (same value in every `*.<lang>.txt`), so keep it identical when adding a translation. In templates, don't hardcode the locale — use `kirby()->language()?->code()` (already done for `<html lang>` in `layout/index.blade.php`).

**Pages are composed from section components.** A page template is almost always just `<x-layout>` wrapping a sequence of section components — e.g. `home.blade.php` is `<x-layout><x-hero /><x-intro /><x-gallery /><x-place /><x-lake /><x-distillery /></x-layout>`. Each section is the standard two-file component (class in `app/View/Components/`, markup in `site/templates/components/<name>.blade.php`) and maps 1:1 to a tab/field group in that page's blueprint (`site/blueprints/pages/<page>.yml`). To add a section: add the fields to the blueprint tab, create the component class + view, and drop `<x-section />` into the page template. Existing pages: `home` (hero/intro/gallery/place/lake/distillery), `process` (hero/steps/closing, with a per-page `darkNav` toggle), `place` (hero/info/feature), and the tequilas system below.

**Images go through `<x-picture>` (`app/View/Components/Picture.php`).** Never emit a bare `<img>` for content images. `<x-picture :file="$file" sizes="…" class="…" />` renders a `<picture>` with a WebP `srcset` (falling back to the original `<img>`), passing through `alt` (from the file's `alt` field), `loading="lazy"`, and any extra attributes/classes you merge. SVGs are emitted as a plain `<img>`. Thumbs are configured in `site/config/thumbs.php` with the **ImageMagick (`im`) driver** (`bin: /opt/homebrew/bin/magick`) and a `webp` srcset (320–1920px). The files blueprint default (`site/blueprints/files/default.yml`) adds `alt` + `caption`. Gotcha: with `w-auto` + only a `max-h`, a small srcset candidate renders at its natural (small) size — drive size with an explicit `h-`/`w-` when you need predictable dimensions (this bit the hero bottle on mobile).

**Scroll animations live in `resources/js/animations.js` (GSAP + ScrollTrigger + Draggable).** Only GSAP free plugins are available (InertiaPlugin is paid → Draggable uses `inertia: false`). Two attribute-driven behaviors, applied by markup alone:
- `data-fade` — fades/rises in on load (opacity + small y). To avoid a flash before JS runs, `layout/index.blade.php` adds a `has-anim` class and pre-hides `[data-fade]` (and the hero's `[data-parallax-bottle]`) with inline CSS.
- `data-parallax="<amount>"` — scroll-scrubbed vertical parallax (`fromTo` y `+amount → -amount`). Generic `[data-parallax]` elements are **not** pre-hidden, so they show immediately and just move.

Two patterns matter: **(1) nested fade + parallax** — put `data-parallax` on a wrapper and `data-fade` on the inner element, never both on the same node (the two y-transforms conflict). **(2) contained parallax** — to move an image without exposing gaps, wrap it in an `overflow-hidden` box and make the image oversized/offset (`absolute inset-x-0 -top-1/4 h-[150%]`) with `data-parallax` on the image. All animations respect `prefers-reduced-motion`.

**Sliders reuse `resources/js/gallery.js`.** Any element marked `data-gallery` (with a `data-gallery-track` flex row of full-width slides and optional `data-gallery-dot` buttons) becomes a mouse/touch-draggable slider — no per-instance JS. It's used by the home gallery, the place `info` vertical slider, and the tequila galleries. Drag threshold is 30% of a slide. Because Tailwind can't see classes that only JS toggles (active-dot styles), `app.css` has `@source "../js"` so those classes are still generated. Likewise non-default utilities need `@theme` tokens — `--container-8xl: 90rem` powers `max-w-8xl`, and the `--font-*` tokens power `font-elzevir`/`font-abhaya`/`font-toyprint`.

**Adaptive nav + footer.** `Nav.php` reads a per-page `darkNav` bool (`@class(['text-white' => $dark])`, logo gets `brightness-0 invert`) so dark hero pages get a white nav. `Footer.php` renders the site-wide **Site data** tab from `site/blueprints/site.yml` (logo, favicon, disclaimer, email, phone, socials) — edit that tab, not the template, for footer content. The site logo is inverted to white via `brightness-0 invert`.

**The Tequilas product system** is a two-level pages setup. The parent `tequilas` blueprint (content at `content/3_our-tequilas/`, template `tequilas`) is just a `pages` section that creates children with the `tequila` template. `TequilaList` loops the listed children and renders each with `<x-tequila-product :page="$product" />`. Each `tequila` page carries its own **layout options** (in the blueprint's *Layout* group, read by `TequilaProduct`): a `flip` toggle (swaps the bottle/text columns) and a `presentationFormat` select (`landscape` 4:3 / `square` 1:1) — layout is controlled **per product**, not by an auto-alternating index. `tequila-product.blade.php` is the editorial block: left column = presentation image as a backdrop with the bottle parallaxing over it and the signature+stamp grouped in one absolutely-positioned wrapper over the image; right column = name (the page title, uppercased) + subtitle + description + the **first** gallery image; any **remaining** gallery images tile in a full-width grid below. The tequila name is the page title (there is no separate name field). When testing a page by creating throwaway content, use an obviously temporary slug (e.g. `zz-test`) and never a real product name — deleting a folder that shares a real slug destroys that product's uploaded files.

**Scheduled tasks** are defined in `site/config/tasks.php` using the `Schedule::call(...)` facade from `beebmx/kirby-scheduler`.

**Bundled beebmx plugins** (in `site/plugins/`, some also in composer): `kirby-blade`, `kirby-env`, `kirby-courier` (mail), `kirby-email-plus`, `kirby-enum`, `kirby-scheduler`, `kirby-sign`. Treat these as vendored dependencies — Pint excludes several of them.

## Environment

`KIRBY_KEY` (used as the cookie key and app key) and `APP_URL` must be set in `.env`. `KIRBY_ENV` drives the Blade environment conditionals and defaults to `production`. See `.env.example` for the full set (cache, session, DB, mail).
