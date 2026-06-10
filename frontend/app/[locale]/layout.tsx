import type { Metadata } from 'next'
import { Inter, Cormorant_Garamond } from 'next/font/google'
import { NextIntlClientProvider } from 'next-intl'
import { getMessages } from 'next-intl/server'
import { notFound } from 'next/navigation'
import { routing } from '@/i18n/routing'
import { Toaster } from 'react-hot-toast'
import CustomCursor from '@/components/ui/CustomCursor'
import Preloader from '@/components/ui/Preloader'
import '../globals.css'

const inter = Inter({ subsets: ['latin', 'cyrillic'], variable: '--font-inter', display: 'swap' })
const cormorant = Cormorant_Garamond({
  subsets: ['latin'],
  weight: ['300', '400', '500', '600', '700'],
  style: ['normal', 'italic'],
  variable: '--font-cormorant',
  display: 'swap',
})

export const metadata: Metadata = {
  title: 'Alpha Zone — Premium B2B Business Platform',
  description: 'Elite venue organization, partner matching, and luxury fleet services for business leaders and executives.',
  keywords: ['business concierge', 'venue booking', 'partner matching', 'luxury fleet', 'VIP services', 'B2B platform'],
  openGraph: {
    title: 'Alpha Zone',
    description: 'Where business meets excellence.',
    type: 'website',
  },
}

export function generateStaticParams() {
  return routing.locales.map((locale) => ({ locale }))
}

export default async function LocaleLayout({
  children,
  params,
}: {
  children: React.ReactNode
  params: { locale: string }
}) {
  const { locale } = params
  if (!routing.locales.includes(locale as any)) notFound()

  const messages = await getMessages()

  return (
    <html lang={locale} className={`${inter.variable} ${cormorant.variable}`}>
      <body className="bg-obsidian text-platinum antialiased min-h-screen">
        <NextIntlClientProvider messages={messages}>
          <CustomCursor />
          <Preloader />
          {children}
          <Toaster
            position="top-right"
            toastOptions={{
              style: {
                background: '#1A1A1A',
                color: '#E8E8E8',
                border: '1px solid #2A2A2A',
                borderRadius: '4px',
                fontFamily: 'Inter, sans-serif',
                fontSize: '14px',
              },
              success: { iconTheme: { primary: '#D4AF37', secondary: '#0A0A0A' } },
              error: { iconTheme: { primary: '#ef4444', secondary: '#0A0A0A' } },
            }}
          />
        </NextIntlClientProvider>
      </body>
    </html>
  )
}
