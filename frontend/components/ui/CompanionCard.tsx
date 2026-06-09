'use client'

import { useState } from 'react'
import Link from 'next/link'
import { motion } from 'framer-motion'
import { Lock, Star, Globe, ArrowRight } from 'lucide-react'

interface Companion {
  id: number
  name: string
  gender: string
  age: number
  rating: number
  reviews: number
  headline: string
  languages: string[]
  skills: string[]
  hourlyRate: number
  eventTypes: string[]
  nationality: string
  isVerified: boolean
  isFeatured: boolean
  image: string
}

export default function CompanionCard({ companion }: { companion: Companion }) {
  const [hovered, setHovered] = useState(false)

  return (
    <motion.div
      variants={{
        initial: { opacity: 0, y: 20 },
        animate: { opacity: 1, y: 0 },
      }}
      transition={{ duration: 0.5, ease: [0.22, 1, 0.36, 1] }}
      className="group relative overflow-hidden rounded-sm bg-elevated border border-border hover:border-gold/25 transition-all duration-500 hover:shadow-gold-sm"
      onMouseEnter={() => setHovered(true)}
      onMouseLeave={() => setHovered(false)}
    >
      {/* Photo with privacy blur */}
      <div className="relative aspect-[3/4] overflow-hidden">
        <img
          src={companion.image}
          alt={companion.name}
          className={`w-full h-full object-cover transition-all duration-700 scale-105 group-hover:scale-110 ${
            hovered ? 'blur-[2px]' : 'blur-md'
          }`}
          style={{ filter: hovered ? 'blur(3px) brightness(0.7)' : 'blur(12px) brightness(0.5)' }}
        />

        {/* Gradient overlay */}
        <div className="absolute inset-0 bg-card-gradient" />

        {/* Featured badge */}
        {companion.isFeatured && (
          <div className="absolute top-3 left-3">
            <span className="text-[9px] tracking-widest uppercase font-semibold text-obsidian bg-gold-gradient px-2 py-0.5">
              Featured
            </span>
          </div>
        )}

        {/* Verified badge */}
        {companion.isVerified && (
          <div className="absolute top-3 right-3">
            <span className="badge-verified">✓ Verified</span>
          </div>
        )}

        {/* Lock overlay */}
        <div className="absolute inset-0 flex items-center justify-center">
          <motion.div
            animate={hovered ? { scale: 0.9, opacity: 0.7 } : { scale: 1, opacity: 1 }}
            transition={{ duration: 0.3 }}
            className="bg-obsidian/70 backdrop-blur-sm border border-gold/20 px-4 py-3 text-center"
          >
            <Lock size={16} className="text-gold mx-auto mb-1" />
            <p className="text-gold text-[9px] tracking-widest uppercase">Book to Reveal</p>
          </motion.div>
        </div>

        {/* Hover CTA overlay */}
        <motion.div
          animate={hovered ? { opacity: 1 } : { opacity: 0 }}
          transition={{ duration: 0.3 }}
          className="absolute inset-0 flex items-end justify-center pb-16"
        >
          <Link
            href={`/companions/${companion.id}`}
            className="bg-gold-gradient text-obsidian text-[10px] font-semibold tracking-widest uppercase px-6 py-2 hover:shadow-gold-md transition-all"
          >
            View Profile
          </Link>
        </motion.div>

        {/* Info at bottom */}
        <div className="absolute bottom-0 left-0 right-0 p-4">
          <p className="text-platinum font-medium text-sm">{companion.name}, {companion.age}</p>
          <p className="text-muted text-xs mt-0.5 leading-tight line-clamp-1">{companion.headline}</p>

          <div className="flex items-center justify-between mt-3">
            <div className="flex items-center gap-1">
              <Star size={11} className="text-gold fill-gold" />
              <span className="text-gold text-xs font-medium">{companion.rating}</span>
              <span className="text-muted text-xs">({companion.reviews})</span>
            </div>
            <span className="text-platinum/70 text-xs">from ${companion.hourlyRate}<span className="text-muted">/hr</span></span>
          </div>
        </div>
      </div>

      {/* Card body */}
      <div className="p-4 space-y-3">
        {/* Languages */}
        <div className="flex items-center gap-2 flex-wrap">
          <Globe size={11} className="text-gold flex-shrink-0" />
          <div className="flex gap-1.5 flex-wrap">
            {companion.languages.slice(0, 3).map((lang) => (
              <span key={lang} className="text-[9px] text-muted tracking-wider uppercase border border-border px-1.5 py-0.5">
                {lang}
              </span>
            ))}
            {companion.languages.length > 3 && (
              <span className="text-[9px] text-gold tracking-wider">+{companion.languages.length - 3}</span>
            )}
          </div>
        </div>

        {/* Skills */}
        <div className="flex gap-1.5 flex-wrap">
          {companion.skills.slice(0, 2).map((skill) => (
            <span key={skill} className="text-[9px] text-muted/70 tracking-wide line-clamp-1">
              {skill}
            </span>
          ))}
        </div>

        {/* Book link */}
        <Link
          href={`/companions/${companion.id}`}
          className="flex items-center justify-between text-gold text-[10px] tracking-widest uppercase font-medium hover:gap-3 transition-all group/link"
        >
          <span>View & Book</span>
          <ArrowRight size={12} className="group-hover/link:translate-x-1 transition-transform" />
        </Link>
      </div>
    </motion.div>
  )
}
