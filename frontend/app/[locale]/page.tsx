'use client'

import { motion } from 'framer-motion'
import { ArrowRight, Shield, Star, Lock, Globe } from 'lucide-react'
import { useTranslations } from 'next-intl'
import { Link } from '@/i18n/navigation'
import Navbar from '@/components/layout/Navbar'
import Footer from '@/components/layout/Footer'

const STATS_KEYS = ['18+', '6', '9', '100%'] as const
const STAT_LABELS = ['companions', 'venues', 'vehicles', 'verified'] as const

const SERVICES = [
  { icon: '◈', key: 'companion', href: '/companions' },
  { icon: '◆', key: 'venue',     href: '/venues' },
  { icon: '◉', key: 'fleet',     href: '/fleet' },
] as const

const TRUST_ICONS = [Shield, Lock, Star, Globe]
const TRUST_KEYS = ['identity', 'escrow', 'privacy', 'global'] as const

const FEATURED = [
  { name: 'Sophia M.',     role: 'Business Etiquette Expert',   rating: 4.97, from: 380, img: 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=400&q=80' },
  { name: 'Yuki T.',       role: 'Professional Translator',      rating: 4.99, from: 350, img: 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=400&q=80' },
  { name: 'Alexander K.',  role: 'Security Protocol Advisor',    rating: 4.98, from: 420, img: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&q=80' },
  { name: 'Mei Lin C.',    role: 'FinTech Executive Liaison',    rating: 4.98, from: 360, img: 'https://images.unsplash.com/photo-1496440737103-cd596325d314?w=400&q=80' },
]

const fadeUp = {
  initial:    { opacity: 0, y: 30 },
  animate:    { opacity: 1, y: 0 },
  transition: { duration: 0.7, ease: [0.22, 1, 0.36, 1] },
}

const stagger = { animate: { transition: { staggerChildren: 0.12 } } }

export default function HomePage() {
  const t  = useTranslations('home')
  const tf = useTranslations('home.featured')

  return (
    <div className="min-h-screen bg-obsidian">
      <Navbar />

      {/* ── HERO ─────────────────────────────────────────────── */}
      <section className="grain-overlay relative min-h-screen flex items-center justify-center overflow-hidden">
        <div
          className="absolute inset-0 bg-cover bg-center bg-no-repeat"
          style={{ backgroundImage: 'url(https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1920&q=85)' }}
        >
          <div className="absolute inset-0 bg-hero-gradient" />
          <div className="absolute inset-0 bg-gradient-to-b from-obsidian/40 via-transparent to-obsidian" />
        </div>

        <div className="relative z-10 text-center px-4 max-w-5xl mx-auto">
          {/* Ornament top */}
          <motion.div
            {...fadeUp}
            className="flex items-center justify-center gap-4 mb-8"
          >
            <div className="w-8 h-px bg-gradient-to-r from-transparent to-gold/60" />
            <p className="text-gold text-[10px] font-medium tracking-[0.5em] uppercase">
              {t('eyebrow')}
            </p>
            <div className="w-8 h-px bg-gradient-to-l from-transparent to-gold/60" />
          </motion.div>

          <motion.h1
            {...fadeUp}
            transition={{ duration: 0.9, delay: 0.1, ease: [0.22, 1, 0.36, 1] }}
            className="font-display font-light leading-[0.9] mb-6"
            style={{ fontSize: 'clamp(4rem, 12vw, 8rem)' }}
          >
            <span className="block text-platinum tracking-[0.04em]">Velvet</span>
            <span className="block text-shimmer italic tracking-[0.06em]">Hour</span>
          </motion.h1>
          <motion.div {...fadeUp} transition={{ delay: 0.2 }} className="gold-rule" />
          <motion.p
            {...fadeUp}
            transition={{ delay: 0.3 }}
            className="text-platinum/70 text-lg md:text-xl font-light tracking-wide max-w-2xl mx-auto mb-12"
          >
            {t('tagline')}
          </motion.p>
          <motion.div {...fadeUp} transition={{ delay: 0.4 }} className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link href="/companions" className="btn-gold">{t('cta1')}</Link>
            <Link href="/auth/register" className="btn-ghost">{t('cta2')}</Link>
          </motion.div>
        </div>

        <motion.div
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ delay: 1.2 }}
          className="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2"
        >
          <span className="text-muted text-[10px] tracking-[0.3em] uppercase">{t('scroll')}</span>
          <motion.div
            animate={{ y: [0, 8, 0] }}
            transition={{ repeat: Infinity, duration: 1.6, ease: 'easeInOut' }}
            className="w-px h-8 bg-gradient-to-b from-gold to-transparent"
          />
        </motion.div>
      </section>

      {/* ── STATS ───────────────────────────────────────────── */}
      <section className="border-y border-border bg-charcoal">
        <div className="max-w-5xl mx-auto px-4 py-8 grid grid-cols-2 md:grid-cols-4 gap-8">
          {STATS_KEYS.map((val, i) => (
            <motion.div
              key={val}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.1 }}
              className="text-center"
            >
              <p className="font-display text-3xl text-gold font-semibold">{val}</p>
              <p className="text-muted text-xs tracking-widest uppercase mt-1">
                {t(`stats.${STAT_LABELS[i]}`)}
              </p>
            </motion.div>
          ))}
        </div>
      </section>

      {/* ── SERVICES ─────────────────────────────────────────── */}
      <section className="py-32 px-4 max-w-6xl mx-auto">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-20"
        >
          <p className="text-gold text-xs tracking-[0.4em] uppercase mb-4">{t('services.eyebrow')}</p>
          <h2 className="font-display text-4xl md:text-5xl text-platinum font-light">
            {t('services.heading')} <em>1%</em>
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
          {SERVICES.map((svc) => (
            <motion.div
              key={svc.key}
              variants={fadeUp}
              className="glass-card p-8 group cursor-pointer hover:border-gold/30 transition-all duration-500 hover:shadow-gold-sm"
            >
              <p className="text-gold text-2xl mb-6 font-display">{svc.icon}</p>
              <h3 className="font-display text-xl text-platinum mb-4 font-medium">
                {t(`services.${svc.key}.title`)}
              </h3>
              <p className="text-muted text-sm leading-relaxed mb-8">
                {t(`services.${svc.key}.desc`)}
              </p>
              <Link
                href={svc.href}
                className="inline-flex items-center gap-2 text-gold text-xs tracking-widest uppercase font-medium hover:gap-3 transition-all"
              >
                {t(`services.${svc.key}.cta`)}
                <ArrowRight size={14} />
              </Link>
            </motion.div>
          ))}
        </motion.div>
      </section>

      {/* ── FEATURED COMPANIONS ──────────────────────────────── */}
      <section className="py-24 bg-charcoal border-y border-border overflow-hidden">
        <div className="max-w-6xl mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            className="flex items-end justify-between mb-16"
          >
            <div>
              <p className="text-gold text-xs tracking-[0.4em] uppercase mb-3">{tf('eyebrow')}</p>
              <h2 className="font-display text-4xl text-platinum font-light">{tf('heading')}</h2>
            </div>
            <Link href="/companions" className="btn-ghost hidden md:inline-flex">{tf('viewAll')}</Link>
          </motion.div>

          <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
            {FEATURED.map((c, i) => (
              <motion.div
                key={c.name}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.1 }}
                className="relative overflow-hidden rounded-sm group cursor-pointer"
              >
                <div className="aspect-[3/4] relative overflow-hidden">
                  <img
                    src={c.img}
                    alt="Companion"
                    className="w-full h-full object-cover scale-110 blur-md group-hover:blur-sm transition-all duration-700"
                  />
                  <div className="absolute inset-0 bg-card-gradient" />
                  <div className="absolute inset-0 flex items-center justify-center">
                    <div className="bg-obsidian/80 backdrop-blur-sm border border-gold/20 rounded-sm px-3 py-2 text-center">
                      <Lock size={14} className="text-gold mx-auto mb-1" />
                      <span className="text-gold text-[9px] tracking-widest uppercase">{tf('bookToReveal')}</span>
                    </div>
                  </div>
                  <div className="absolute bottom-0 left-0 right-0 p-4">
                    <div className="badge-verified mb-2">✓ {tf('verified')}</div>
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
            <Link href="/companions" className="btn-ghost">{tf('viewAll')}</Link>
          </div>
        </div>
      </section>

      {/* ── TRUST PILLARS ────────────────────────────────────── */}
      <section className="py-32 px-4 max-w-6xl mx-auto">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-20"
        >
          <p className="text-gold text-xs tracking-[0.4em] uppercase mb-4">{t('trust.eyebrow')}</p>
          <h2 className="font-display text-4xl md:text-5xl text-platinum font-light">
            {t('trust.heading')} <em>{t('trust.headingItalic')}</em>
          </h2>
          <div className="gold-rule" />
        </motion.div>

        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
          {TRUST_KEYS.map((key, i) => {
            const Icon = TRUST_ICONS[i]
            return (
              <motion.div
                key={key}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.1 }}
                className="text-center px-4"
              >
                <div className="w-14 h-14 border border-gold/30 rounded-sm flex items-center justify-center mx-auto mb-6 animate-gold-pulse">
                  <Icon size={22} className="text-gold" />
                </div>
                <h3 className="font-display text-lg text-platinum mb-3">{t(`trust.${key}.title`)}</h3>
                <p className="text-muted text-sm leading-relaxed">{t(`trust.${key}.desc`)}</p>
              </motion.div>
            )
          })}
        </div>
      </section>

      {/* ── TESTIMONIALS ────────────────────────────────────── */}
      <section className="py-28 px-4 bg-charcoal border-y border-border">
        <div className="max-w-5xl mx-auto">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            className="text-center mb-16"
          >
            <p className="text-gold text-xs tracking-[0.4em] uppercase mb-4">Testimonials</p>
            <h2 className="font-display text-4xl md:text-5xl text-platinum font-light">
              Voices of the <em>Elite</em>
            </h2>
            <div className="gold-rule" />
          </motion.div>

          <div className="grid md:grid-cols-3 gap-6">
            {[
              { quote: 'The most discreet and professional concierge experience I have encountered across three continents. VelvetHour operates at a different level entirely.', initials: 'A.K.', title: 'Managing Partner, Sovereign Capital' },
              { quote: 'From diplomatic reception planning to fleet coordination — executed flawlessly. My team has never presented better to our Gulf partners.', initials: 'R.M.', title: 'CEO, Meridian Holdings' },
              { quote: 'Invitation-only means something here. Every companion is exceptional, every venue immaculate. This is what genuine exclusivity feels like.', initials: 'S.T.', title: 'Principal Investor, Asia Pacific' },
            ].map((t, i) => (
              <motion.div
                key={i}
                initial={{ opacity: 0, y: 24 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.12 }}
                className="glass-card p-8 relative"
              >
                <div className="text-gold/20 font-display text-6xl leading-none absolute top-4 left-6 select-none">"</div>
                <p className="text-platinum/70 text-sm leading-relaxed mb-6 pt-4 italic">
                  {t.quote}
                </p>
                <div className="flex items-center gap-3 pt-4 border-t border-border">
                  <div className="w-9 h-9 border border-gold/30 flex items-center justify-center">
                    <span className="font-display text-sm text-gold font-medium">{t.initials}</span>
                  </div>
                  <p className="text-muted text-xs tracking-wide">{t.title}</p>
                </div>
              </motion.div>
            ))}
          </div>
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
              <p className="text-gold text-xs tracking-[0.4em] uppercase mb-6">{t('cta.eyebrow')}</p>
              <h2 className="font-display text-4xl md:text-6xl text-platinum font-light mb-6">
                {t('cta.heading')}
              </h2>
              <div className="gold-rule" />
              <p className="text-platinum/60 text-base max-w-lg mx-auto mb-10">{t('cta.body')}</p>
              <Link href="/auth/register" className="btn-gold text-base">{t('cta.btn')}</Link>
            </motion.div>
          </div>
        </div>
      </section>

      <Footer />
    </div>
  )
}
