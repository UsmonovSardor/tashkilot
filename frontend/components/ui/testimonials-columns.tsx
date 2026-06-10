"use client"

import React from "react"
import { motion } from "framer-motion"

export interface Testimonial {
  text: string
  image: string
  name: string
  role: string
}

export function TestimonialsColumn({
  className,
  testimonials,
  duration = 10,
}: {
  className?: string
  testimonials: Testimonial[]
  duration?: number
}) {
  return (
    <div className={className} style={{ overflow: 'hidden' }}>
      <motion.div
        animate={{ translateY: "-50%" }}
        transition={{
          duration,
          repeat: Infinity,
          ease: "linear",
          repeatType: "loop",
        }}
        className="flex flex-col gap-4 pb-4"
      >
        {[...new Array(2).fill(0).map((_, index) => (
          <React.Fragment key={index}>
            {testimonials.map(({ text, image, name, role }, i) => (
              <div
                key={i}
                className="p-6 rounded-2xl border border-gold/20 bg-charcoal/80 shadow-lg shadow-gold/5 max-w-xs w-full"
              >
                <p className="text-platinum/80 text-sm leading-relaxed italic">"{text}"</p>
                <div className="flex items-center gap-3 mt-4">
                  <img
                    width={40}
                    height={40}
                    src={image}
                    alt={name}
                    className="h-10 w-10 rounded-full object-cover border border-gold/20"
                  />
                  <div className="flex flex-col">
                    <div className="font-medium text-platinum text-sm tracking-tight">{name}</div>
                    <div className="text-xs text-muted tracking-tight">{role}</div>
                  </div>
                </div>
              </div>
            ))}
          </React.Fragment>
        ))]}
      </motion.div>
    </div>
  )
}
