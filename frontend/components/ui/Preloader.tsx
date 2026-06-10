'use client'

import { useEffect, useState } from 'react'
import { motion, AnimatePresence } from 'framer-motion'

export default function Preloader() {
  const [visible, setVisible] = useState(true)
  const [progress, setProgress] = useState(0)

  useEffect(() => {
    // Check if already shown this session
    if (sessionStorage.getItem('vh_loaded')) {
      setVisible(false)
      return
    }

    let p = 0
    const interval = setInterval(() => {
      p += Math.random() * 18 + 6
      if (p >= 100) {
        p = 100
        clearInterval(interval)
        setTimeout(() => {
          setVisible(false)
          sessionStorage.setItem('vh_loaded', '1')
        }, 600)
      }
      setProgress(Math.min(p, 100))
    }, 120)

    return () => clearInterval(interval)
  }, [])

  return (
    <AnimatePresence>
      {visible && (
        <motion.div
          initial={{ opacity: 1 }}
          exit={{ opacity: 0 }}
          transition={{ duration: 0.7, ease: [0.22, 1, 0.36, 1] }}
          className="fixed inset-0 z-[99999] bg-obsidian flex flex-col items-center justify-center"
        >
          {/* VH Monogram */}
          <motion.div
            initial={{ opacity: 0, scale: 0.8 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ duration: 0.6, ease: [0.22, 1, 0.36, 1] }}
            className="relative mb-10"
          >
            {/* Rotating ring */}
            <svg
              className="absolute inset-0 w-full h-full animate-preloader-ring"
              viewBox="0 0 80 80"
              style={{ width: 80, height: 80 }}
            >
              <circle
                cx="40" cy="40" r="36"
                fill="none"
                stroke="url(#ringGrad)"
                strokeWidth="1"
                strokeDasharray="80 146"
                strokeLinecap="round"
              />
              <defs>
                <linearGradient id="ringGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stopColor="#D4AF37" stopOpacity="0" />
                  <stop offset="50%" stopColor="#F5D469" />
                  <stop offset="100%" stopColor="#D4AF37" stopOpacity="0" />
                </linearGradient>
              </defs>
            </svg>

            {/* Diamond ornament */}
            <div className="w-20 h-20 border border-gold/20 rotate-45 flex items-center justify-center">
              <div className="w-14 h-14 border border-gold/10 rotate-0 flex items-center justify-center -rotate-45">
                <span
                  className="font-display text-2xl font-light tracking-[0.15em] text-gold"
                  style={{ fontFamily: 'var(--font-cormorant), Georgia, serif' }}
                >
                  VH
                </span>
              </div>
            </div>
          </motion.div>

          {/* Wordmark */}
          <motion.p
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.3, duration: 0.5 }}
            className="font-display text-lg font-light tracking-[0.5em] uppercase text-platinum/60 mb-8"
            style={{ fontFamily: 'var(--font-cormorant), Georgia, serif' }}
          >
            VelvetHour
          </motion.p>

          {/* Progress bar */}
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ delay: 0.4 }}
            className="w-32 h-px bg-elevated overflow-hidden"
          >
            <div
              className="h-full bg-gold-gradient transition-all duration-150 ease-out"
              style={{ width: `${progress}%` }}
            />
          </motion.div>
        </motion.div>
      )}
    </AnimatePresence>
  )
}
