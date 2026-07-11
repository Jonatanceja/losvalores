import gsap from 'gsap'
import Draggable from 'gsap/Draggable'

gsap.registerPlugin(Draggable)

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches

function initGallery(gallery) {
  const track = gallery.querySelector('[data-gallery-track]')
  const slides = gsap.utils.toArray(track.children)
  if (slides.length <= 1) return

  const dots = gsap.utils.toArray(gallery.querySelectorAll('[data-gallery-dot]'))
  const slideWidth = () => gallery.offsetWidth

  let index = 0
  let draggable

  function syncDots() {
    dots.forEach((dot, i) => {
      const active = i === index
      dot.classList.toggle('w-5', active)
      dot.classList.toggle('bg-white', active)
      dot.classList.toggle('w-1.5', !active)
      dot.classList.toggle('bg-white/40', !active)
    })
  }

  function goTo(target, animate = true) {
    index = gsap.utils.clamp(0, slides.length - 1, Math.round(target))
    gsap.to(track, {
      x: -index * slideWidth(),
      duration: animate && !reduceMotion ? 0.6 : 0,
      ease: 'power3.out',
      onComplete: () => draggable && draggable.update(),
    })
    syncDots()
  }

  // Mouse / touch drag.
  ;[draggable] = Draggable.create(track, {
    type: 'x',
    inertia: false,
    cursor: 'grab',
    activeCursor: 'grabbing',
    onPress() {
      this.applyBounds({ minX: -(slides.length - 1) * slideWidth(), maxX: 0 })
    },
    onDragEnd() {
      // Advance when the drag passes 30% of the slide width (no need to reach
      // 50%); otherwise snap back to the current slide.
      const threshold = 0.3
      const diff = -this.x / slideWidth() - index
      if (diff > threshold) goTo(index + 1)
      else if (diff < -threshold) goTo(index - 1)
      else goTo(index)
    },
  })

  dots.forEach((dot, i) => dot.addEventListener('click', () => goTo(i)))

  // Keyboard support.
  gallery.setAttribute('tabindex', '0')
  gallery.addEventListener('keydown', (event) => {
    if (event.key === 'ArrowLeft') goTo(index - 1)
    if (event.key === 'ArrowRight') goTo(index + 1)
  })

  // Keep the current slide aligned on resize.
  window.addEventListener('resize', () => goTo(index, false))

  syncDots()
}

document.querySelectorAll('[data-gallery]').forEach(initGallery)
