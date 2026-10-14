import gsap from 'gsap'
import ScrollTrigger from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches

// Respect reduced motion: leave everything visible and static.
if (!reduceMotion) {
  // Fade-in for every marked element — all site elements except the
  // illustration and the background, which are intentionally left static.
  // They are pre-hidden via the `.has-anim [data-fade]` CSS in the layout,
  // so GSAP reveals them without a flash.
  gsap.set('[data-fade]', { y: 24 })
  gsap.to('[data-fade]', {
    opacity: 1,
    y: 0,
    duration: 0.9,
    ease: 'power2.out',
    stagger: 0.12,
    clearProps: 'transform',
  })

  // Parallax drift for marked elements (intro, place, …). Each element travels
  // from +amount to -amount as it passes through the viewport, tied to scroll.
  // The `data-parallax` value is the travel in pixels (default 80);
  // `data-parallax-sm` optionally overrides it below 768px.
  const isMobile = window.matchMedia('(max-width: 767px)').matches
  gsap.utils.toArray('[data-parallax]').forEach((el) => {
    const amount =
      parseFloat((isMobile && el.dataset.parallaxSm) || el.dataset.parallax) || 80
    gsap.fromTo(
      el,
      { y: amount },
      {
        y: -amount,
        ease: 'none',
        scrollTrigger: {
          trigger: el,
          start: 'top bottom',
          end: 'bottom top',
          scrub: true,
          invalidateOnRefresh: true,
        },
      },
    )
  })

  const bottle = document.querySelector('[data-parallax-bottle]')
  const illustration = document.querySelector('[data-illustration]')

  if (bottle) {
    // Bottle fades in (opacity only, so its `y` stays free for the parallax).
    gsap.to(bottle, { opacity: 1, duration: 1, ease: 'power2.out' })

    // Mobile: a gentle drift so the bottle moves a little against the scroll.
    gsap.matchMedia().add('(max-width: 767px)', () => {
      gsap.to(bottle, {
        y: 40,
        ease: 'none',
        scrollTrigger: {
          trigger: bottle.closest('section'),
          start: 'top top',
          end: 'bottom top',
          scrub: true,
        },
      })
    })

    // Parallax (desktop only): the bottle advances downward until its bottom
    // meets the bottom of the illustration, but the travel ends as soon as the
    // next section (the text) starts entering the viewport.
    if (illustration) {
      const heroSection = bottle.closest('section')
      const nextSection = heroSection?.nextElementSibling

      gsap.matchMedia().add('(min-width: 768px)', () => {
        gsap.to(bottle, {
          y: () =>
            Math.max(
              illustration.getBoundingClientRect().bottom -
                bottle.getBoundingClientRect().bottom,
              0,
            ),
          ease: 'none',
          scrollTrigger: {
            trigger: heroSection,
            start: 'top top',
            endTrigger: nextSection ?? heroSection,
            end: nextSection ? 'top bottom' : 'bottom bottom',
            scrub: true,
            invalidateOnRefresh: true,
          },
        })
      })
    }
  }
}
