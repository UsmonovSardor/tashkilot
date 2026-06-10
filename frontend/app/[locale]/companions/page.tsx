'use client'

import { useState } from 'react'
import { motion } from 'framer-motion'
import { Lock, Search, ChevronDown } from 'lucide-react'
import { useTranslations } from 'next-intl'
import Navbar from '@/components/layout/Navbar'
import Footer from '@/components/layout/Footer'
import CompanionCard from '@/components/ui/CompanionCard'
import CompanionCardSkeleton from '@/components/ui/CompanionCardSkeleton'

const DEMO_COMPANIONS = [
  { id: 1,  name: 'Sophia M.',      gender: 'female', age: 24, rating: 4.97, reviews: 52, headline: 'International Business Etiquette Expert',       languages: ['English', 'French', 'Russian'],              skills: ['Business Etiquette', 'Wine Pairing', 'Luxury Real Estate'],           hourlyRate: 380, eventTypes: ['corporate', 'gala', 'diplomatic'], nationality: 'British',       isVerified: true, isFeatured: true,  image: 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=600&q=85' },
  { id: 2,  name: 'Anastasia V.',   gender: 'female', age: 26, rating: 4.94, reviews: 38, headline: 'Art Connoisseur & Cultural Ambassador',          languages: ['Russian', 'English', 'German'],              skills: ['Fine Art Advisory', 'Art Collection Curation', 'Classical Music'],     hourlyRate: 320, eventTypes: ['cultural', 'art', 'social'],       nationality: 'Russian',       isVerified: true, isFeatured: false, image: 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=600&q=85' },
  { id: 3,  name: 'Yuki T.',        gender: 'female', age: 23, rating: 4.99, reviews: 61, headline: 'Professional Translator & Cross-Cultural Liaison', languages: ['Japanese', 'English', 'Mandarin', 'Korean'], skills: ['Simultaneous Interpretation', 'Asian Business Protocol', 'Tea Ceremony'], hourlyRate: 350, eventTypes: ['corporate', 'diplomatic', 'luxury_travel'], nationality: 'Japanese', isVerified: true, isFeatured: true, image: 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=600&q=85' },
  { id: 4,  name: 'Isabella F.',    gender: 'female', age: 28, rating: 4.92, reviews: 44, headline: 'Luxury Fashion Stylist & Haute Couture Expert',   languages: ['French', 'English', 'Italian'],              skills: ['Haute Couture', 'Jewellery Advisory', 'Red Carpet Protocol'],         hourlyRate: 290, eventTypes: ['fashion', 'social', 'gala'],       nationality: 'French',        isVerified: true, isFeatured: false, image: 'https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?w=600&q=85' },
  { id: 5,  name: 'Diana A.',       gender: 'female', age: 25, rating: 4.96, reviews: 55, headline: 'MENA Cultural Liaison & VIP Events Specialist',  languages: ['Arabic', 'English', 'French', 'Urdu'],       skills: ['Gulf Business Protocol', 'Arabic Interpretation', 'Luxury Real Estate Liaison'], hourlyRate: 340, eventTypes: ['corporate', 'diplomatic', 'gala'], nationality: 'Emirati', isVerified: true, isFeatured: true, image: 'https://images.unsplash.com/photo-1506863530036-1efeddceb993?w=600&q=85' },
  { id: 6,  name: 'Valentina G.',   gender: 'female', age: 27, rating: 4.93, reviews: 47, headline: 'Gastronomy Expert, Sommelier & Private Chef Liaison', languages: ['Italian', 'English', 'Spanish'],          skills: ['Fine Dining Curation', 'Wine Expertise', 'Private Chef Coordination'], hourlyRate: 310, eventTypes: ['culinary', 'social', 'corporate'], nationality: 'Italian', isVerified: true, isFeatured: false, image: 'https://images.unsplash.com/photo-1502823403499-6ccfcf4fb453?w=600&q=85' },
  { id: 7,  name: 'Mei Lin C.',     gender: 'female', age: 29, rating: 4.98, reviews: 63, headline: 'Tech & FinTech Executive Liaison — Asia Pacific', languages: ['Mandarin', 'English', 'Cantonese', 'Bahasa'], skills: ['VC & Startup Ecosystem', 'DeFi & Blockchain', 'Investment Summits'], hourlyRate: 360, eventTypes: ['corporate', 'fintech', 'diplomatic'], nationality: 'Singaporean', isVerified: true, isFeatured: true, image: 'https://images.unsplash.com/photo-1496440737103-cd596325d314?w=600&q=85' },
  { id: 8,  name: 'Layla O.',       gender: 'female', age: 22, rating: 4.95, reviews: 33, headline: 'Classical Pianist & High Society Entertainment Consultant', languages: ['Arabic', 'English', 'French'], skills: ['Classical Piano', 'Entertainment Curation', 'Event Hosting'], hourlyRate: 300, eventTypes: ['cultural', 'entertainment', 'gala'], nationality: 'Egyptian', isVerified: true, isFeatured: false, image: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=600&q=85' },
  { id: 9,  name: 'Alexander K.',   gender: 'male',   age: 30, rating: 4.98, reviews: 71, headline: 'Former Royal Navy Officer & Security Protocol Advisor', languages: ['English', 'Arabic', 'Russian'],           skills: ['VIP Security Protocol', 'Diplomatic Events', 'Crisis Management'],    hourlyRate: 420, eventTypes: ['corporate', 'diplomatic', 'security'], nationality: 'British', isVerified: true, isFeatured: true, image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&q=85' },
  { id: 10, name: 'Rafael M.',      gender: 'male',   age: 27, rating: 4.95, reviews: 48, headline: 'Luxury Yacht & Motorsport Lifestyle Consultant',  languages: ['Portuguese', 'English', 'Spanish', 'French'], skills: ['Yacht Charter', 'Motorsport Hospitality', 'Polo & Equestrian'],     hourlyRate: 390, eventTypes: ['sports', 'motorsport', 'social'],   nationality: 'Brazilian',     isVerified: true, isFeatured: false, image: 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=600&q=85' },
  { id: 11, name: 'Omar A.',        gender: 'male',   age: 26, rating: 5.00, reviews: 29, headline: 'Royal Protocol Expert & Middle East Investment Liaison', languages: ['Arabic', 'English', 'French', 'Farsi'],   skills: ['Royal Protocol', 'GCC Investment', 'Arabic Interpretation'],          hourlyRate: 450, eventTypes: ['diplomatic', 'corporate', 'investment'], nationality: 'Omani', isVerified: true, isFeatured: true, image: 'https://images.unsplash.com/photo-1556474835-b0f3ac40d4d1?w=600&q=85' },
  { id: 12, name: 'James W.',       gender: 'male',   age: 31, rating: 4.96, reviews: 58, headline: 'Silicon Valley VC & Tech Conference Navigator',  languages: ['English', 'Mandarin', 'Spanish'],            skills: ['VC Networking', 'Tech Conference Navigation', 'M&A Facilitation'],   hourlyRate: 410, eventTypes: ['corporate', 'fintech', 'tech'],      nationality: 'American',      isVerified: true, isFeatured: false, image: 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=600&q=85' },
]

const EVENT_TYPE_KEYS = ['all', 'corporate', 'diplomatic', 'gala', 'cultural', 'fintech', 'social', 'wellness'] as const
const LANGUAGES = ['All', 'English', 'French', 'Russian', 'Arabic', 'Mandarin', 'Japanese', 'Italian']

export default function CompanionsPage() {
  const t = useTranslations('companions')
  const [loading]     = useState(false)
  const [eventFilter, setEventFilter] = useState('all')
  const [langFilter,  setLangFilter]  = useState('All')
  const [sortBy,      setSortBy]      = useState('rating')
  const [searchQuery, setSearchQuery] = useState('')
  const [viewerGender] = useState<'male' | 'female'>('male')

  const oppositeGender = viewerGender === 'male' ? 'female' : 'male'

  const filtered = DEMO_COMPANIONS.filter((c) => {
    if (c.gender !== oppositeGender) return false
    if (eventFilter !== 'all' && !c.eventTypes.includes(eventFilter)) return false
    if (langFilter !== 'All' && !c.languages.includes(langFilter)) return false
    if (searchQuery) {
      const q = searchQuery.toLowerCase()
      return (
        c.name.toLowerCase().includes(q) ||
        c.headline.toLowerCase().includes(q) ||
        c.skills.some((s) => s.toLowerCase().includes(q))
      )
    }
    return true
  })

  const sorted = [...filtered].sort((a, b) => {
    if (sortBy === 'rating')      return b.rating - a.rating
    if (sortBy === 'hourly_asc')  return a.hourlyRate - b.hourlyRate
    if (sortBy === 'hourly_desc') return b.hourlyRate - a.hourlyRate
    return b.rating - a.rating
  })

  const SORT_OPTIONS = [
    { value: 'rating',      label: t('sort.rating') },
    { value: 'hourly_asc',  label: t('sort.hourlyAsc') },
    { value: 'hourly_desc', label: t('sort.hourlyDesc') },
    { value: 'ai_match',    label: t('sort.aiMatch') },
  ]

  return (
    <div className="min-h-screen bg-obsidian">
      <Navbar />

      <section className="pt-28 pb-16 px-4 border-b border-border">
        <div className="max-w-6xl mx-auto">
          <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.6 }}>
            <p className="text-gold text-xs tracking-[0.4em] uppercase mb-3">{t('eyebrow')}</p>
            <h1 className="font-display text-5xl md:text-6xl text-platinum font-light mb-4">{t('heading')}</h1>
            <p className="text-muted text-base max-w-xl">
              {t('countLabel', { count: sorted.length })}
            </p>
          </motion.div>
        </div>
      </section>

      <section className="sticky top-16 z-30 bg-charcoal/95 backdrop-blur-md border-b border-border">
        <div className="max-w-6xl mx-auto px-4 py-4">
          <div className="flex flex-col md:flex-row gap-4 items-start md:items-center">
            <div className="relative flex-1 max-w-sm">
              <Search size={14} className="absolute left-3 top-1/2 -translate-y-1/2 text-muted" />
              <input
                type="text"
                placeholder={t('search')}
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="w-full bg-elevated border border-border text-platinum text-sm pl-9 pr-4 py-2.5 placeholder:text-muted/50 focus:outline-none focus:border-gold/50 transition-colors"
              />
            </div>

            <div className="flex gap-2 overflow-x-auto pb-1 flex-1">
              {EVENT_TYPE_KEYS.map((key) => (
                <button
                  key={key}
                  onClick={() => setEventFilter(key)}
                  className={`flex-shrink-0 text-[10px] tracking-widest uppercase px-3 py-1.5 border transition-all ${
                    eventFilter === key
                      ? 'border-gold bg-gold/10 text-gold'
                      : 'border-border text-muted hover:border-gold/30 hover:text-platinum'
                  }`}
                >
                  {t(`filters.${key}`)}
                </button>
              ))}
            </div>

            <div className="relative">
              <select
                value={sortBy}
                onChange={(e) => setSortBy(e.target.value)}
                className="appearance-none bg-elevated border border-border text-muted text-xs tracking-wider uppercase px-4 py-2.5 pr-8 focus:outline-none focus:border-gold/50 cursor-pointer"
              >
                {SORT_OPTIONS.map((o) => (
                  <option key={o.value} value={o.value}>{o.label}</option>
                ))}
              </select>
              <ChevronDown size={12} className="absolute right-3 top-1/2 -translate-y-1/2 text-muted pointer-events-none" />
            </div>
          </div>
        </div>
      </section>

      <section className="py-12 px-4">
        <div className="max-w-6xl mx-auto">
          {loading ? (
            <div className="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
              {Array.from({ length: 8 }).map((_, i) => <CompanionCardSkeleton key={i} />)}
            </div>
          ) : sorted.length === 0 ? (
            <div className="text-center py-24">
              <p className="font-display text-2xl text-platinum/30">{t('noResults')}</p>
              <button
                onClick={() => { setEventFilter('all'); setSearchQuery('') }}
                className="mt-6 btn-ghost"
              >
                {t('clearFilters')}
              </button>
            </div>
          ) : (
            <motion.div
              className="grid md:grid-cols-3 lg:grid-cols-4 gap-6"
              initial="initial"
              animate="animate"
              variants={{ animate: { transition: { staggerChildren: 0.07 } } }}
            >
              {sorted.map((companion) => (
                <CompanionCard key={companion.id} companion={companion} />
              ))}
            </motion.div>
          )}
        </div>
      </section>

      <Footer />
    </div>
  )
}
