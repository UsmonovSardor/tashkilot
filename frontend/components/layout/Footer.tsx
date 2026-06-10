'use client'

import { useTranslations } from 'next-intl'
import { Link } from '@/i18n/navigation'

export default function Footer() {
  const t = useTranslations('footer')

  const serviceItems = t.raw('serviceItems') as string[]
  const legalItems = t.raw('legalItems') as string[]

  return (
    <footer className="bg-charcoal border-t border-border py-16 px-4">
      <div className="max-w-6xl mx-auto">
        <div className="grid md:grid-cols-4 gap-12 mb-16">
          <div className="md:col-span-2">
            <p className="font-display text-2xl mb-4">
              <span className="text-platinum">Velvet</span>
              <span className="text-gold italic">Hour</span>
            </p>
            <p className="text-muted text-sm leading-relaxed max-w-xs">{t('tagline')}</p>
            <div className="mt-6 flex gap-1">
              <div className="w-8 h-px bg-gold" />
              <div className="w-4 h-px bg-gold/40" />
              <div className="w-2 h-px bg-gold/20" />
            </div>
          </div>

          <div>
            <p className="text-platinum text-xs tracking-widest uppercase mb-6">{t('services')}</p>
            <div className="flex flex-col gap-3">
              {serviceItems.map((s) => (
                <span
                  key={s}
                  className="text-muted text-sm hover:text-gold cursor-pointer transition-colors"
                >
                  {s}
                </span>
              ))}
            </div>
          </div>

          <div>
            <p className="text-platinum text-xs tracking-widest uppercase mb-6">{t('legal')}</p>
            <div className="flex flex-col gap-3">
              {legalItems.map((s) => (
                <span
                  key={s}
                  className="text-muted text-sm hover:text-gold cursor-pointer transition-colors"
                >
                  {s}
                </span>
              ))}
            </div>
          </div>
        </div>

        <div className="border-t border-border pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
          <p className="text-muted text-xs tracking-wider">{t('copyright')}</p>
          <p className="text-muted/50 text-[10px] tracking-widest uppercase">{t('cities')}</p>
        </div>
      </div>
    </footer>
  )
}
