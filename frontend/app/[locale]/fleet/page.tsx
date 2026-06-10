'use client'

import { motion } from 'framer-motion'
import { Users, ArrowRight } from 'lucide-react'
import { useTranslations } from 'next-intl'
import { Link } from '@/i18n/navigation'
import Navbar from '@/components/layout/Navbar'
import Footer from '@/components/layout/Footer'

const FLEET = [
  {
    id: 1,
    make: 'Rolls-Royce',
    model: 'Phantom',
    year: 2024,
    color: 'Midnight Obsidian',
    passengers: 4,
    hourlyRate: 850,
    languages: ['English', 'Russian', 'Arabic'],
    features: ['Starlight Headliner', 'Bespoke Bar', 'Privacy Glass', 'Wi-Fi'],
    image: 'https://images.unsplash.com/photo-1563720223185-11003d516935?w=800&q=85',
    featured: true,
  },
  {
    id: 2,
    make: 'Bentley',
    model: 'Mulsanne',
    year: 2023,
    color: 'Silverlake',
    passengers: 4,
    hourlyRate: 720,
    languages: ['English', 'French', 'German'],
    features: ['Hand-Stitched Leather', 'Massage Seats', 'Refrigerator', 'Privacy Curtains'],
    image: 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?w=800&q=85',
    featured: true,
  },
  {
    id: 3,
    make: 'Mercedes-Maybach',
    model: 'S 680',
    year: 2024,
    color: 'Obsidian Black',
    passengers: 4,
    hourlyRate: 680,
    languages: ['English', 'Russian', 'German', 'Uzbek'],
    features: ['Executive Rear Suite', 'MBUX Rear', 'Burmester Audio', 'Air Suspension'],
    image: 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=800&q=85',
    featured: false,
  },
  {
    id: 4,
    make: 'Range Rover',
    model: 'SV Autobiography',
    year: 2024,
    color: 'Carpathian Grey',
    passengers: 6,
    hourlyRate: 480,
    languages: ['English', 'Russian', 'Arabic', 'French'],
    features: ['4x4 Capability', 'Panoramic Roof', 'Executive Seating', 'Night Vision'],
    image: 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=800&q=85',
    featured: false,
  },
  {
    id: 5,
    make: 'Cadillac',
    model: 'Escalade ESV',
    year: 2024,
    color: 'Black Raven',
    passengers: 7,
    hourlyRate: 420,
    languages: ['English', 'Russian', 'Arabic'],
    features: ['AKG Studio Sound', 'Super Cruise', 'Rear Entertainment', 'Privacy Glass'],
    image: 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=800&q=85',
    featured: false,
  },
  {
    id: 6,
    make: 'Rolls-Royce',
    model: 'Cullinan',
    year: 2024,
    color: 'Salamanca Blue',
    passengers: 4,
    hourlyRate: 920,
    languages: ['English', 'Arabic', 'Mandarin', 'French'],
    features: ['Recreation Module', 'Viewing Suite', 'Self-Levelling', 'Night Vision'],
    image: 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=800&q=85',
    featured: true,
  },
  {
    id: 7,
    make: 'Mercedes-Benz',
    model: 'V-Class VIP',
    year: 2023,
    color: 'Obsidian Black',
    passengers: 6,
    hourlyRate: 380,
    languages: ['English', 'Russian', 'Uzbek', 'German'],
    features: ['Conference Setup', 'Rear Tables', 'Mini Bar', 'Privacy Partition'],
    image: 'https://images.unsplash.com/photo-1502877338535-766e1452684a?w=800&q=85',
    featured: false,
  },
  {
    id: 8,
    make: 'BMW',
    model: '760Li M Sport',
    year: 2024,
    color: 'Tanzanite Blue',
    passengers: 4,
    hourlyRate: 560,
    languages: ['English', 'Russian', 'German', 'Chinese'],
    features: ['M Sport Package', 'Executive Lounge', 'Rear Screen', 'Bowers & Wilkins'],
    image: 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=800&q=85',
    featured: false,
  },
  {
    id: 9,
    make: 'Lexus',
    model: 'LM 500h VIP',
    year: 2024,
    color: 'Sonic Titanium',
    passengers: 4,
    hourlyRate: 440,
    languages: ['English', 'Japanese', 'Russian', 'Korean'],
    features: ['4-Seat Executive', 'Partition Screen', 'Ottoman Seat', 'Mark Levinson Audio'],
    image: 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=800&q=85',
    featured: false,
  },
]

const fadeUp = {
  initial:    { opacity: 0, y: 30 },
  animate:    { opacity: 1, y: 0 },
  transition: { duration: 0.6, ease: [0.22, 1, 0.36, 1] },
}

export default function FleetPage() {
  const t = useTranslations('fleet')

  return (
    <div className="min-h-screen bg-obsidian">
      <Navbar />

      <section className="pt-28 pb-16 px-4 border-b border-border">
        <div className="max-w-6xl mx-auto">
          <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.6 }}>
            <p className="text-gold text-xs tracking-[0.4em] uppercase mb-3">{t('eyebrow')}</p>
            <h1 className="font-display text-5xl md:text-6xl text-platinum font-light mb-4">{t('heading')}</h1>
            <p className="text-muted text-base max-w-xl">{t('countLabel', { count: FLEET.length })}</p>
          </motion.div>
        </div>
      </section>

      <section className="py-16 px-4">
        <div className="max-w-6xl mx-auto">
          <motion.div
            className="grid md:grid-cols-2 lg:grid-cols-3 gap-6"
            initial="initial"
            animate="animate"
            variants={{ animate: { transition: { staggerChildren: 0.09 } } }}
          >
            {FLEET.map((vehicle) => (
              <motion.div
                key={vehicle.id}
                variants={fadeUp}
                className="glass-card overflow-hidden group hover:border-gold/30 transition-all duration-500 hover:shadow-gold-sm"
              >
                <div className="relative aspect-[16/9] overflow-hidden">
                  <img
                    src={vehicle.image}
                    alt={`${vehicle.make} ${vehicle.model}`}
                    className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-obsidian/80 via-transparent to-transparent" />
                  {vehicle.featured && (
                    <div className="absolute top-3 left-3 badge-verified">★ Featured</div>
                  )}
                  <div className="absolute bottom-3 right-3 bg-obsidian/90 border border-gold/20 px-3 py-1.5 backdrop-blur-sm">
                    <p className="text-gold font-display text-sm font-semibold">
                      ${vehicle.hourlyRate}{t('perHour')}
                    </p>
                  </div>
                </div>

                <div className="p-6">
                  <p className="text-gold text-[10px] tracking-widest uppercase mb-1">{vehicle.year} · {vehicle.color}</p>
                  <h3 className="font-display text-xl text-platinum mb-4">
                    {vehicle.make} <span className="italic">{vehicle.model}</span>
                  </h3>

                  <div className="flex items-center gap-4 mb-5 text-xs text-muted">
                    <div className="flex items-center gap-1.5">
                      <Users size={12} className="text-gold/60" />
                      <span>{vehicle.passengers} {t('passengers')}</span>
                    </div>
                  </div>

                  <div className="mb-3">
                    <p className="text-platinum/40 text-[10px] tracking-widest uppercase mb-2">{t('languages')}</p>
                    <div className="flex flex-wrap gap-1.5">
                      {vehicle.languages.map((lang) => (
                        <span key={lang} className="text-[10px] text-muted border border-border px-2 py-0.5 tracking-wide">
                          {lang}
                        </span>
                      ))}
                    </div>
                  </div>

                  <div className="mb-6">
                    <div className="flex flex-wrap gap-1.5">
                      {vehicle.features.slice(0, 3).map((f) => (
                        <span key={f} className="text-[10px] text-muted/70 border border-border/50 px-2 py-0.5">
                          {f}
                        </span>
                      ))}
                      {vehicle.features.length > 3 && (
                        <span className="text-[10px] text-gold/60 border border-gold/20 px-2 py-0.5">
                          +{vehicle.features.length - 3}
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
