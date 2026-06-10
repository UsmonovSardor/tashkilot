'use client'

import { useLocale } from 'next-intl'
import { useRouter, usePathname } from '@/i18n/navigation'
import { useState, useRef, useEffect } from 'react'
import { ChevronDown } from 'lucide-react'

const LOCALES = [
  { code: 'en', label: 'EN', name: 'English' },
  { code: 'ru', label: 'RU', name: 'Русский' },
  { code: 'uz', label: 'UZ', name: "O'zbek" },
]

export default function LanguageSwitcher() {
  const locale = useLocale()
  const router = useRouter()
  const pathname = usePathname()
  const [open, setOpen] = useState(false)
  const ref = useRef<HTMLDivElement>(null)

  useEffect(() => {
    const handler = (e: MouseEvent) => {
      if (ref.current && !ref.current.contains(e.target as Node)) setOpen(false)
    }
    document.addEventListener('mousedown', handler)
    return () => document.removeEventListener('mousedown', handler)
  }, [])

  const current = LOCALES.find((l) => l.code === locale) ?? LOCALES[0]

  return (
    <div ref={ref} className="relative">
      <button
        onClick={() => setOpen(!open)}
        className="flex items-center gap-1 text-muted text-xs tracking-widest uppercase hover:text-gold transition-colors duration-300 py-1"
      >
        {current.label}
        <ChevronDown
          size={10}
          className={`transition-transform duration-200 ${open ? 'rotate-180' : ''}`}
        />
      </button>

      {open && (
        <div className="absolute right-0 top-full mt-2 min-w-[120px] bg-charcoal border border-border shadow-elevated z-50">
          {LOCALES.map((loc) => (
            <button
              key={loc.code}
              onClick={() => {
                router.replace(pathname, { locale: loc.code })
                setOpen(false)
              }}
              className={`w-full text-left px-4 py-2.5 text-xs tracking-wider transition-colors ${
                loc.code === locale
                  ? 'text-gold bg-gold/5'
                  : 'text-muted hover:text-platinum hover:bg-elevated'
              }`}
            >
              <span className="font-semibold mr-2">{loc.label}</span>
              <span className="opacity-60">{loc.name}</span>
            </button>
          ))}
        </div>
      )}
    </div>
  )
}
