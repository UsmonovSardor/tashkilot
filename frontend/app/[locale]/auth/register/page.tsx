'use client'

import { useState } from 'react'
import { motion } from 'framer-motion'
import { Eye, EyeOff, CheckCircle } from 'lucide-react'
import { useTranslations } from 'next-intl'
import { Link } from '@/i18n/navigation'
import toast from 'react-hot-toast'

export default function RegisterPage() {
  const t = useTranslations('auth.register')
  const [showPass, setShowPass] = useState(false)
  const [loading, setLoading] = useState(false)
  const [submitted, setSubmitted] = useState(false)
  const [form, setForm] = useState({
    firstName: '', lastName: '', email: '', password: '', confirmPassword: '',
  })

  const set = (k: keyof typeof form) => (e: React.ChangeEvent<HTMLInputElement>) =>
    setForm({ ...form, [k]: e.target.value })

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    if (form.password !== form.confirmPassword) {
      toast.error('Passwords do not match.')
      return
    }
    setLoading(true)
    await new Promise((r) => setTimeout(r, 1500))
    setLoading(false)
    setSubmitted(true)
  }

  if (submitted) {
    return (
      <div className="min-h-screen bg-obsidian flex items-center justify-center px-4">
        <motion.div
          initial={{ opacity: 0, scale: 0.95 }}
          animate={{ opacity: 1, scale: 1 }}
          className="text-center max-w-md"
        >
          <div className="w-16 h-16 border border-gold/30 rounded-full flex items-center justify-center mx-auto mb-8">
            <CheckCircle size={28} className="text-gold" />
          </div>
          <h2 className="font-display text-3xl text-platinum font-light mb-4">Request Received</h2>
          <div className="gold-rule" />
          <p className="text-muted text-sm mb-8">{t('disclaimer')}</p>
          <Link href="/" className="btn-ghost">Return Home</Link>
        </motion.div>
      </div>
    )
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

          <form onSubmit={handleSubmit} className="space-y-4">
            <div className="grid grid-cols-2 gap-4">
              <div>
                <label className="block text-platinum/60 text-xs tracking-widest uppercase mb-2">{t('firstName')}</label>
                <input
                  type="text" required value={form.firstName} onChange={set('firstName')}
                  className="w-full bg-elevated border border-border text-platinum text-sm px-4 py-3 placeholder:text-muted/40 focus:outline-none focus:border-gold/50 transition-colors"
                />
              </div>
              <div>
                <label className="block text-platinum/60 text-xs tracking-widest uppercase mb-2">{t('lastName')}</label>
                <input
                  type="text" required value={form.lastName} onChange={set('lastName')}
                  className="w-full bg-elevated border border-border text-platinum text-sm px-4 py-3 placeholder:text-muted/40 focus:outline-none focus:border-gold/50 transition-colors"
                />
              </div>
            </div>

            <div>
              <label className="block text-platinum/60 text-xs tracking-widest uppercase mb-2">{t('email')}</label>
              <input
                type="email" required value={form.email} onChange={set('email')}
                placeholder="you@example.com"
                className="w-full bg-elevated border border-border text-platinum text-sm px-4 py-3 placeholder:text-muted/40 focus:outline-none focus:border-gold/50 transition-colors"
              />
            </div>

            <div>
              <label className="block text-platinum/60 text-xs tracking-widest uppercase mb-2">{t('password')}</label>
              <div className="relative">
                <input
                  type={showPass ? 'text' : 'password'} required value={form.password} onChange={set('password')}
                  placeholder="••••••••"
                  className="w-full bg-elevated border border-border text-platinum text-sm px-4 py-3 pr-11 placeholder:text-muted/40 focus:outline-none focus:border-gold/50 transition-colors"
                />
                <button
                  type="button" onClick={() => setShowPass(!showPass)}
                  className="absolute right-3 top-1/2 -translate-y-1/2 text-muted hover:text-gold transition-colors"
                >
                  {showPass ? <EyeOff size={16} /> : <Eye size={16} />}
                </button>
              </div>
            </div>

            <div>
              <label className="block text-platinum/60 text-xs tracking-widest uppercase mb-2">{t('confirmPassword')}</label>
              <input
                type={showPass ? 'text' : 'password'} required value={form.confirmPassword} onChange={set('confirmPassword')}
                placeholder="••••••••"
                className="w-full bg-elevated border border-border text-platinum text-sm px-4 py-3 placeholder:text-muted/40 focus:outline-none focus:border-gold/50 transition-colors"
              />
            </div>

            <button
              type="submit" disabled={loading}
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

          <p className="text-muted/50 text-[11px] text-center mt-6 leading-relaxed">{t('disclaimer')}</p>

          <p className="text-muted text-sm text-center mt-6">
            {t('haveAccount')}{' '}
            <Link href="/auth/login" className="text-gold hover:text-gold/80 transition-colors">
              {t('login')}
            </Link>
          </p>
        </div>
      </motion.div>
    </div>
  )
}
