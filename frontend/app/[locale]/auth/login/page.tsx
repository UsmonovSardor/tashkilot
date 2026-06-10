'use client'

import { useState } from 'react'
import { motion } from 'framer-motion'
import { Eye, EyeOff } from 'lucide-react'
import { useTranslations } from 'next-intl'
import { Link } from '@/i18n/navigation'
import toast from 'react-hot-toast'

export default function LoginPage() {
  const t = useTranslations('auth.login')
  const [showPass, setShowPass] = useState(false)
  const [loading, setLoading] = useState(false)
  const [form, setForm] = useState({ email: '', password: '' })

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setLoading(true)
    await new Promise((r) => setTimeout(r, 1200))
    toast.error('Backend integration pending.')
    setLoading(false)
  }

  return (
    <div className="min-h-screen bg-obsidian flex items-center justify-center px-4 py-20">
      <motion.div
        initial={{ opacity: 0, y: 30 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.6 }}
        className="w-full max-w-md"
      >
        <Link href="/" className="block text-center font-display text-2xl mb-10">
          <span className="text-platinum">Velvet</span>
          <span className="text-gold italic">Hour</span>
        </Link>

        <div className="glass-card p-8 md:p-10">
          <h1 className="font-display text-3xl text-platinum font-light mb-2">{t('heading')}</h1>
          <p className="text-muted text-sm mb-8">{t('sub')}</p>

          <form onSubmit={handleSubmit} className="space-y-5">
            <div>
              <label className="block text-platinum/60 text-xs tracking-widest uppercase mb-2">
                {t('email')}
              </label>
              <input
                type="email"
                required
                value={form.email}
                onChange={(e) => setForm({ ...form, email: e.target.value })}
                className="w-full bg-elevated border border-border text-platinum text-sm px-4 py-3 placeholder:text-muted/40 focus:outline-none focus:border-gold/50 transition-colors"
                placeholder="you@example.com"
              />
            </div>

            <div>
              <div className="flex items-center justify-between mb-2">
                <label className="text-platinum/60 text-xs tracking-widest uppercase">
                  {t('password')}
                </label>
                <button type="button" className="text-gold text-[11px] hover:text-gold/80 transition-colors">
                  {t('forgot')}
                </button>
              </div>
              <div className="relative">
                <input
                  type={showPass ? 'text' : 'password'}
                  required
                  value={form.password}
                  onChange={(e) => setForm({ ...form, password: e.target.value })}
                  className="w-full bg-elevated border border-border text-platinum text-sm px-4 py-3 pr-11 placeholder:text-muted/40 focus:outline-none focus:border-gold/50 transition-colors"
                  placeholder="••••••••"
                />
                <button
                  type="button"
                  onClick={() => setShowPass(!showPass)}
                  className="absolute right-3 top-1/2 -translate-y-1/2 text-muted hover:text-gold transition-colors"
                >
                  {showPass ? <EyeOff size={16} /> : <Eye size={16} />}
                </button>
              </div>
            </div>

            <button
              type="submit"
              disabled={loading}
              className="w-full btn-gold mt-2 flex items-center justify-center gap-2 disabled:opacity-60"
            >
              {loading ? (
                <motion.div
                  animate={{ rotate: 360 }}
                  transition={{ repeat: Infinity, duration: 0.8, ease: 'linear' }}
                  className="w-4 h-4 border-2 border-obsidian/40 border-t-obsidian rounded-full"
                />
              ) : t('submit')}
            </button>
          </form>

          <p className="text-muted text-sm text-center mt-8">
            {t('noAccount')}{' '}
            <Link href="/auth/register" className="text-gold hover:text-gold/80 transition-colors">
              {t('register')}
            </Link>
          </p>
        </div>
      </motion.div>
    </div>
  )
}
