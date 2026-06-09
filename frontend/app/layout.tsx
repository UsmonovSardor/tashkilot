import type { Metadata } from 'next'
import { Inter, Playfair_Display } from 'next/font/google'
import './globals.css'
import { Toaster } from 'react-hot-toast'

const inter = Inter({
  subsets: ['latin'],
  variable: '--font-inter',
  display: 'swap',
})

const playfair = Playfair_Display({
  subsets: ['latin'],
  variable: '--font-playfair',
  display: 'swap',
})

export const metadata: Metadata = {
  title: 'VelvetHour — Ultra-Premium Concierge Platform',
  description: 'Exclusive companion matching, luxury venue booking, and chauffeur fleet services for the discerning elite.',
  keywords: ['luxury concierge', 'elite companion', 'VIP booking', 'luxury venue', 'chauffeur service'],
  openGraph: {
    title: 'VelvetHour',
    description: 'Where exclusivity meets experience.',
    type: 'website',
  },
}

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en" className={`${inter.variable} ${playfair.variable}`}>
      <body className="bg-obsidian text-platinum antialiased min-h-screen">
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
            success: {
              iconTheme: { primary: '#D4AF37', secondary: '#0A0A0A' },
            },
            error: {
              iconTheme: { primary: '#ef4444', secondary: '#0A0A0A' },
            },
          }}
        />
      </body>
    </html>
  )
}
