'use client'

import { useState, useEffect } from 'react'
import { motion, AnimatePresence } from 'framer-motion'
import { Menu, X } from 'lucide-react'
import { useTranslations } from 'next-intl'
import { Link } from '@/i18n/navigation'
import LanguageSwitcher from '@/components/ui/LanguageSwitcher'

export default function Navbar() {
  const t = useTranslations('nav')
  const [scrolled, setScrolled] = useState(false)
  const [menuOpen, setMenuOpen] = useState(false)

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 40)
    window.addEventListener('scroll', onScroll)
    return () => window.removeEventListener('scroll', onScroll)
  }, [])

  const navLinks = [
    { label: t('companions'), href: '/companions' },
    { label: t('venues'), href: '/venues' },
    { label: t('fleet'), href: '/fleet' },
  ]

  return (
    <>
      <motion.nav
        initial={{ opacity: 0, y: -10 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.6 }}
        className={`fixed top-0 left-0 right-0 z-50 transition-all duration-500 ${
          scrolled
            ? 'bg-charcoal/95 backdrop-blur-md border-b border-border shadow-elevated'
            : 'bg-transparent'
        }`}
      >
        <div className="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
          <Link href="/" className="font-display text-xl font-medium tracking-wider">
            <span className="text-platinum">Velvet</span>
            <span className="text-gold italic">Hour</span>
          </Link>

          <div className="hidden md:flex items-center gap-10">
            {navLinks.map((link) => (
              <Link
                key={link.href}
                href={link.href}
                className="text-muted text-xs tracking-widest uppercase hover:text-gold transition-colors duration-300"
              >
                {link.label}
              </Link>
            ))}
          </div>

          <div className="hidden md:flex items-center gap-5">
            <LanguageSwitcher />
            <Link
              href="/auth/login"
              className="text-muted text-xs tracking-widest uppercase hover:text-platinum transition-colors"
            >
              {t('signIn')}
            </Link>
            <Link href="/auth/register" className="btn-gold !px-5 !py-2 !text-[10px]">
              {t('requestAccess')}
            </Link>
          </div>

          <button
            onClick={() => setMenuOpen(!menuOpen)}
            className="md:hidden text-muted hover:text-gold transition-colors"
          >
            {menuOpen ? <X size={20} /> : <Menu size={20} />}
          </button>
        </div>
      </motion.nav>

      <AnimatePresence>
        {menuOpen && (
          <motion.div
            initial={{ opacity: 0, y: -20 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -20 }}
            className="fixed inset-0 z-40 bg-charcoal/98 backdrop-blur-md pt-20 px-6 md:hidden"
          >
            <div className="flex flex-col gap-8 mt-10">
              {navLinks.map((link) => (
                <Link
                  key={link.href}
                  href={link.href}
                  onClick={() => setMenuOpen(false)}
                  className="font-display text-2xl text-platinum hover:text-gold transition-colors"
                >
                  {link.label}
                </Link>
              ))}
              <div className="pt-8 border-t border-border flex flex-col gap-4">
                <div className="flex justify-center">
                  <LanguageSwitcher />
                </div>
                <Link
                  href="/auth/login"
                  onClick={() => setMenuOpen(false)}
                  className="btn-ghost text-center"
                >
                  {t('signIn')}
                </Link>
                <Link
                  href="/auth/register"
                  onClick={() => setMenuOpen(false)}
                  className="btn-gold text-center"
                >
                  {t('requestAccess')}
                </Link>
              </div>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </>
  )
}
