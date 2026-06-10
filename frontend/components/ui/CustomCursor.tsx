'use client'

import { useEffect, useRef } from 'react'

export default function CustomCursor() {
  const dotRef  = useRef<HTMLDivElement>(null)
  const ringRef = useRef<HTMLDivElement>(null)

  useEffect(() => {
    const dot  = dotRef.current
    const ring = ringRef.current
    if (!dot || !ring) return

    let ringX = 0, ringY = 0
    let mouseX = 0, mouseY = 0
    let hovered = false
    let raf: number

    const move = (e: MouseEvent) => {
      mouseX = e.clientX
      mouseY = e.clientY
      dot.style.transform = `translate(${mouseX}px, ${mouseY}px) translate(-50%, -50%)`

      const el = e.target as HTMLElement
      hovered = !!(
        el.closest('a') ||
        el.closest('button') ||
        el.closest('[role="button"]') ||
        el.closest('input') ||
        el.closest('select') ||
        el.closest('[data-cursor="pointer"]')
      )
    }

    const tick = () => {
      ringX += (mouseX - ringX) * 0.12
      ringY += (mouseY - ringY) * 0.12
      ring.style.transform = `translate(${ringX}px, ${ringY}px) translate(-50%, -50%) scale(${hovered ? 1.8 : 1})`
      ring.style.opacity = hovered ? '0.6' : '1'
      raf = requestAnimationFrame(tick)
    }

    window.addEventListener('mousemove', move, { passive: true })
    raf = requestAnimationFrame(tick)

    return () => {
      window.removeEventListener('mousemove', move)
      cancelAnimationFrame(raf)
    }
  }, [])

  return (
    <>
      {/* Inner dot */}
      <div
        ref={dotRef}
        className="fixed top-0 left-0 z-[9999] pointer-events-none"
        style={{ willChange: 'transform' }}
      >
        <div className="w-1.5 h-1.5 rounded-full bg-gold shadow-[0_0_6px_rgba(212,175,55,0.9)]" />
      </div>
      {/* Outer ring */}
      <div
        ref={ringRef}
        className="fixed top-0 left-0 z-[9998] pointer-events-none transition-[opacity,transform] duration-150"
        style={{ willChange: 'transform' }}
      >
        <div
          className="w-8 h-8 rounded-full border border-gold/50"
          style={{ boxShadow: '0 0 12px rgba(212,175,55,0.15)' }}
        />
      </div>
    </>
  )
}
