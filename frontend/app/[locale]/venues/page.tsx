'use client'

import { motion } from 'framer-motion'
import { Users, ArrowRight } from 'lucide-react'
import { useTranslations } from 'next-intl'
import { Link } from '@/i18n/navigation'
import Navbar from '@/components/layout/Navbar'
import Footer from '@/components/layout/Footer'

const VENUES = [
  {
    id: 1,
    name: 'The Obsidian Penthouse',
    location: 'Tashkent · 42nd Floor',
    type: 'Private Penthouse',
    capacity: 30,
    hourlyRate: 1200,
    amenities: ['Private Pool', 'Butler Service', 'Panoramic Views', 'Chef Kitchen'],
    image: 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&q=85',
    featured: true,
  },
  {
    id: 2,
    name: 'Rooftop Terrace Luxe',
    location: 'Tashkent · Mirzo Ulugbek',
    type: 'Rooftop Venue',
    capacity: 80,
    hourlyRate: 2800,
    amenities: ['Open Air', 'Full Bar', 'Live Music Stage', 'Firepit Lounge'],
    image: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=85',
    featured: true,
  },
  {
    id: 3,
    name: 'The Vault Members Club',
    location: 'Tashkent · Old City',
    type: 'Private Members Club',
    capacity: 20,
    hourlyRate: 900,
    amenities: ['Cigar Lounge', 'Whiskey Library', 'Poker Room', 'Vaulted Ceilings'],
    image: 'https://images.unsplash.com/photo-1528360983277-13d401cdc186?w=800&q=85',
    featured: false,
  },
  {
    id: 4,
    name: 'Estate Villa Aurum',
    location: 'Tashkent Suburbs · Private Estate',
    type: 'Estate Villa',
    capacity: 150,
    hourlyRate: 4500,
    amenities: ['Private Gardens', 'Infinity Pool', 'Helipad', 'Multi-room', 'Security Detail'],
    image: 'https://images.unsplash.com/photo-1613977257363-707ba9348227?w=800&q=85',
    featured: true,
  },
  {
    id: 5,
    name: 'Crystal Boardroom',
    location: 'Tashkent · Business Centre',
    type: 'Executive Boardroom',
    capacity: 16,
    hourlyRate: 600,
    amenities: ['AV Suite', 'Interpreter Booth', 'Catering', 'Video Conference'],
    image: 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=85',
    featured: false,
  },
  {
    id: 6,
    name: 'The Pearl Ballroom',
    location: 'Tashkent · Grand Hotel',
    type: 'Grand Ballroom',
    capacity: 300,
    hourlyRate: 8000,
    amenities: ['Full Stage', 'Dance Floor', 'Gala Lighting', 'Bridal Suite', 'Valet Parking'],
    image: 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=800&q=85',
    featured: false,
  },
]

const fadeUp = {
  initial:    { opacity: 0, y: 30 },
  animate:    { opacity: 1, y: 0 },
  transition: { duration: 0.6, ease: [0.22, 1, 0.36, 1] },
}

export default function VenuesPage() {
  const t = useTranslations('venues')

  return (
    <div className="min-h-screen bg-obsidian">
      <Navbar />

      <section className="pt-28 pb-16 px-4 border-b border-border">
        <div className="max-w-6xl mx-auto">
          <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.6 }}>
            <p className="text-gold text-xs tracking-[0.4em] uppercase mb-3">{t('eyebrow')}</p>
            <h1 className="font-display text-5xl md:text-6xl text-platinum font-light mb-4">{t('heading')}</h1>
            <p className="text-muted text-base max-w-xl">{t('countLabel', { count: VENUES.length })}</p>
          </motion.div>
        </div>
      </section>

      <section className="py-16 px-4">
        <div className="max-w-6xl mx-auto">
          <motion.div
            className="grid md:grid-cols-2 lg:grid-cols-3 gap-6"
            initial="initial"
            animate="animate"
            variants={{ animate: { transition: { staggerChildren: 0.1 } } }}
          >
            {VENUES.map((venue) => (
              <motion.div key={venue.id} variants={fadeUp} className="glass-card overflow-hidden group hover:border-gold/30 transition-all duration-500 hover:shadow-gold-sm">
                <div className="relative aspect-[16/10] overflow-hidden">
                  <img
                    src={venue.image}
                    alt={venue.name}
                    className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-obsidian/80 via-transparent to-transparent" />
                  {venue.featured && (
                    <div className="absolute top-3 left-3 badge-verified">★ Featured</div>
                  )}
                  <div className="absolute bottom-3 right-3 bg-obsidian/90 border border-gold/20 px-3 py-1.5 backdrop-blur-sm">
                    <p className="text-gold font-display text-sm font-semibold">
                      ${venue.hourlyRate}{t('perHour')}
                    </p>
                  </div>
                </div>

                <div className="p-6">
                  <p className="text-gold text-[10px] tracking-widest uppercase mb-2">{venue.type}</p>
                  <h3 className="font-display text-xl text-platinum mb-1">{venue.name}</h3>
                  <p className="text-muted text-xs mb-4">{venue.location}</p>

                  <div className="flex items-center gap-2 mb-5">
                    <Users size={12} className="text-gold/60" />
                    <span className="text-muted text-xs">{t('capacity')}: {venue.capacity}</span>
                  </div>

                  <div className="mb-6">
                    <p className="text-platinum/40 text-[10px] tracking-widest uppercase mb-2">{t('amenities')}</p>
                    <div className="flex flex-wrap gap-1.5">
                      {venue.amenities.slice(0, 3).map((a) => (
                        <span key={a} className="text-[10px] text-muted border border-border px-2 py-0.5 tracking-wide">
                          {a}
                        </span>
                      ))}
                      {venue.amenities.length > 3 && (
                        <span className="text-[10px] text-gold/60 border border-gold/20 px-2 py-0.5">
                          +{venue.amenities.length - 3}
                        </span>
                      )}
                    </div>
                  </div>

                  <Link
                    href="/auth/register"
                    className="inline-flex items-center gap-2 text-gold text-xs tracking-widest uppercase font-medium hover:gap-3 transition-all"
                  >
                    {t('book')} <ArrowRight size={14} />
                  </Link>
                </div>
              </motion.div>
            ))}
          </motion.div>
        </div>
      </section>

      <Footer />
    </div>
  )
}
