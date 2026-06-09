'use client'

import { motion } from 'framer-motion'
import Link from 'next/link'
import { ArrowRight, Shield, Star, Lock, Globe } from 'lucide-react'
import Navbar from '@/components/layout/Navbar'
import Footer from '@/components/layout/Footer'

const STATS = [
  { value: '18+',    label: 'Elite Companions' },
  { value: '6',      label: 'Exclusive Venues' },
  { value: '9',      label: 'Luxury Vehicles' },
  { value: '100%',   label: 'Verified Profiles' },
]

const SERVICES = [
  {
    icon: '◈',
    title: 'Elite Companion Matching',
    description: 'AI-powered pairing of multi-lingual, skill-verified companions to your exact event requirements. Corporate galas, diplomatic dinners, international travel.',
    href: '/companions',
    cta: 'Browse Companions',
  },
  {
    icon: '◆',
    title: 'Premium Venue Booking',
    description: 'Private penthouses, rooftop terraces, secret members clubs, and estate villas — bookable by the hour. Real-time availability with dynamic VIP add-ons.',
    href: '/venues',
    cta: 'Explore Venues',
  },
  {
    icon: '◉',
    title: 'Luxury Fleet & Chauffeur',
    description: 'Rolls-Royce, Bentley, Maybach. Multi-lingual drivers with VIP protocol training. Hourly, daily, and airport transfer rates.',
    href: '/fleet',
    cta: 'View Fleet',
  },
]

const TRUST_PILLARS = [
  {
    icon: Shield,
    title: 'Verified Identities',
    description: 'Every companion and driver undergoes rigorous background verification, document checks, and in-person vetting.',
  },
  {
    icon: Lock,
    title: 'Escrow-Protected Payments',
    description: 'Funds are held in secure escrow and only released to providers after event completion — zero risk for clients.',
  },
  {
    icon: Star,
    title: 'Privacy Masking',
    description: 'Companion photos remain blurred until a booking is confirmed. Your discretion is our architecture.',
  },
  {
    icon: Globe,
    title: 'Global Multi-Lingual',
    description: '15+ languages across our network. From Mandarin boardroom dinners to Arabic diplomatic receptions.',
  },
]

const fadeUp = {
  initial:   { opacity: 0, y: 30 },
  animate:   { opacity: 1, y: 0 },
  transition:{ duration: 0.7, ease: [0.22, 1, 0.36, 1] },
}

const stagger = {
  animate: { transition: { staggerChildren: 0.12 } },
}

export default function HomePage() {
  return (
    <div className="min-h-screen bg-obsidian">
      <Navbar />

      {/* ── HERO ──────────────────────────────────────────────── */}
      <section className="relative min-h-screen flex items-center justify-center overflow-hidden">
        {/* Background image */}
        <div
          className="absolute inset-0 bg-cover bg-center bg-no-repeat"
          style={{
            backgroundImage: 'url(https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1920&q=85)',
          }}
        >
          <div className="absolute inset-0 bg-hero-gradient" />
          <div className="absolute inset-0 bg-gradient-to-b from-obsidian/40 via-transparent to-obsidian" />
        </div>

        <div className="relative z-10 text-center px-4 max-w-5xl mx-auto">
          {/* Eyebrow */}
          <motion.p
            {...fadeUp}
            className="text-gold text-xs font-semibold tracking-[0.4em] uppercase mb-8"
          >
            Invitation Only · Est. 2024 · Tashkent
          </motion.p>

          {/* Wordmark */}
          <motion.h1
            {...fadeUp}
            transition={{ duration: 0.8, delay: 0.1, ease: [0.22, 1, 0.36, 1] }}
            className="font-display text-6xl md:text-8xl lg:text-9xl font-light text-platinum leading-none mb-6"
          >
            Velvet
            <span className="block italic text-gold">Hour</span>
          </motion.h1>

          {/* Rule */}
          <motion.div
            {...fadeUp}
            transition={{ delay: 0.2 }}
            className="gold-rule"
          />

          {/* Tagline */}
          <motion.p
            {...fadeUp}
            transition={{ delay: 0.3 }}
            className="text-platinum/70 text-lg md:text-xl font-light tracking-wide max-w-2xl mx-auto mb-12"
          >
            The world's most exclusive concierge platform.
            Elite companions, curated venues, and a luxury fleet — all under one discreet roof.
          </motion.p>

          {/* CTAs */}
          <motion.div
            {...fadeUp}
            transition={{ delay: 0.4 }}
            className="flex flex-col sm:flex-row gap-4 justify-center"
          >
            <Link href="/companions" className="btn-gold">
              Explore Companions
            </Link>
            <Link href="/auth/register" className="btn-ghost">
              Request Access
            </Link>
          </motion.div>
        </div>

        {/* Scroll indicator */}
        <motion.div
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ delay: 1.2 }}
          className="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2"
        >
          <span className="text-muted text-[10px] tracking-[0.3em] uppercase">Scroll</span>
          <motion.div
            animate={{ y: [0, 8, 0] }}
            transition={{ repeat: Infinity, duration: 1.6, ease: 'easeInOut' }}
            className="w-px h-8 bg-gradient-to-b from-gold to-transparent"
          />
        </motion.div>
      </section>

      {/* ── STATS BAR ────────────────────────────────────────── */}
      <section className="border-y border-border bg-charcoal">
        <div className="max-w-5xl mx-auto px-4 py-8 grid grid-cols-2 md:grid-cols-4 gap-8">
          {STATS.map((s, i) => (
            <motion.div
              key={s.label}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.1 }}
              className="text-center"
            >
              <p className="font-display text-3xl text-gold font-semibold">{s.value}</p>
              <p className="text-muted text-xs tracking-widest uppercase mt-1">{s.label}</p>
            </motion.div>
          ))}
        </div>
      </section>

      {/* ── SERVICES ────────────────────────────────────────── */}
      <section className="py-32 px-4 max-w-6xl mx-auto">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-20"
        >
          <p className="text-gold text-xs tracking-[0.4em] uppercase mb-4">Our Services</p>
          <h2 className="font-display text-4xl md:text-5xl text-platinum font-light">
            Curated for the <em>1%</em>
          </h2>
          <div className="gold-rule" />
        </motion.div>

        <motion.div
          variants={stagger}
          initial="initial"
          whileInView="animate"
          viewport={{ once: true }}
          className="grid md:grid-cols-3 gap-6"
        >
          {SERVICES.map((service) => (
            <motion.div
              key={service.title}
              variants={fadeUp}
              className="glass-card p-8 group cursor-pointer hover:border-gold/30 transition-all duration-500 hover:shadow-gold-sm"
            >
              <p className="text-gold text-2xl mb-6 font-display">{service.icon}</p>
              <h3 className="font-display text-xl text-platinum mb-4 font-medium">
                {service.title}
              </h3>
              <p className="text-muted text-sm leading-relaxed mb-8">
                {service.description}
              </p>
              <Link
                href={service.href}
                className="inline-flex items-center gap-2 text-gold text-xs tracking-widest uppercase font-medium hover:gap-3 transition-all"
              >
                {service.cta}
                <ArrowRight size={14} />
              </Link>
            </motion.div>
          ))}
        </motion.div>
      </section>

      {/* ── FEATURED COMPANIONS TEASER ───────────────────────── */}
      <section className="py-24 bg-charcoal border-y border-border overflow-hidden">
        <div className="max-w-6xl mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            className="flex items-end justify-between mb-16"
          >
            <div>
              <p className="text-gold text-xs tracking-[0.4em] uppercase mb-3">Featured</p>
              <h2 className="font-display text-4xl text-platinum font-light">Elite Companions</h2>
            </div>
            <Link href="/companions" className="btn-ghost hidden md:inline-flex">
              View All
            </Link>
          </motion.div>

          {/* Blurred preview cards */}
          <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
            {[
              { name: 'Sophia M.',   role: 'Business Etiquette Expert',   rating: 4.97, from: 380, img: 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=400&q=80' },
              { name: 'Yuki T.',     role: 'Professional Translator',      rating: 4.99, from: 350, img: 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=400&q=80' },
              { name: 'Alexander K.',role: 'Security Protocol Advisor',    rating: 4.98, from: 420, img: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&q=80' },
              { name: 'Mei Lin C.',  role: 'FinTech Executive Liaison',    rating: 4.98, from: 360, img: 'https://images.unsplash.com/photo-1496440737103-cd596325d314?w=400&q=80' },
            ].map((c, i) => (
              <motion.div
                key={c.name}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.1 }}
                className="relative overflow-hidden rounded-sm group cursor-pointer"
              >
                {/* Blurred image — privacy masking */}
                <div className="aspect-[3/4] relative overflow-hidden">
                  <img
                    src={c.img}
                    alt="Companion"
                    className="w-full h-full object-cover scale-110 blur-md group-hover:blur-sm transition-all duration-700"
                  />
                  <div className="absolute inset-0 bg-card-gradient" />

                  {/* Lock overlay */}
                  <div className="absolute inset-0 flex items-center justify-center">
                    <div className="bg-obsidian/80 backdrop-blur-sm border border-gold/20 rounded-sm px-3 py-2 text-center">
                      <Lock size={14} className="text-gold mx-auto mb-1" />
                      <span className="text-gold text-[9px] tracking-widest uppercase">Book to Reveal</span>
                    </div>
                  </div>

                  {/* Info overlay */}
                  <div className="absolute bottom-0 left-0 right-0 p-4">
                    <div className="badge-verified mb-2">✓ Verified</div>
                    <p className="text-platinum text-sm font-medium">{c.name}</p>
                    <p className="text-muted text-xs mt-0.5">{c.role}</p>
                    <div className="flex items-center justify-between mt-2">
                      <span className="text-gold text-xs">★ {c.rating}</span>
                      <span className="text-platinum/60 text-xs">from ${c.from}/hr</span>
                    </div>
                  </div>
                </div>
              </motion.div>
            ))}
          </div>

          <div className="mt-8 text-center md:hidden">
            <Link href="/companions" className="btn-ghost">View All Companions</Link>
          </div>
        </div>
      </section>

      {/* ── TRUST PILLARS ───────────────────────────────────── */}
      <section className="py-32 px-4 max-w-6xl mx-auto">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-20"
        >
          <p className="text-gold text-xs tracking-[0.4em] uppercase mb-4">Why VelvetHour</p>
          <h2 className="font-display text-4xl md:text-5xl text-platinum font-light">
            Security. Discretion. <em>Excellence.</em>
          </h2>
          <div className="gold-rule" />
        </motion.div>

        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
          {TRUST_PILLARS.map((pillar, i) => (
            <motion.div
              key={pillar.title}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.1 }}
              className="text-center px-4"
            >
              <div className="w-14 h-14 border border-gold/30 rounded-sm flex items-center justify-center mx-auto mb-6 animate-gold-pulse">
                <pillar.icon size={22} className="text-gold" />
              </div>
              <h3 className="font-display text-lg text-platinum mb-3">{pillar.title}</h3>
              <p className="text-muted text-sm leading-relaxed">{pillar.description}</p>
            </motion.div>
          ))}
        </div>
      </section>

      {/* ── CTA BANNER ──────────────────────────────────────── */}
      <section className="relative overflow-hidden">
        <div
          className="bg-cover bg-center"
          style={{ backgroundImage: 'url(https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1920&q=80)' }}
        >
          <div className="bg-obsidian/85 backdrop-blur-[2px] py-28 px-4 text-center">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
            >
              <p className="text-gold text-xs tracking-[0.4em] uppercase mb-6">Access by Invitation</p>
              <h2 className="font-display text-4xl md:text-6xl text-platinum font-light mb-6">
                Ready to experience<br className="hidden md:block" /> the extraordinary?
              </h2>
              <div className="gold-rule" />
              <p className="text-platinum/60 text-base max-w-lg mx-auto mb-10">
                Join a curated community of founders, executives, and tastemakers who expect nothing less than flawless.
              </p>
              <Link href="/auth/register" className="btn-gold text-base">
                Request Your Invitation
              </Link>
            </motion.div>
          </div>
        </div>
      </section>

      <Footer />
    </div>
  )
}
