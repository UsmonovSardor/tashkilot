import type { Config } from 'tailwindcss'

const config: Config = {
  content: [
    './pages/**/*.{js,ts,jsx,tsx,mdx}',
    './components/**/*.{js,ts,jsx,tsx,mdx}',
    './app/**/*.{js,ts,jsx,tsx,mdx}',
  ],
  theme: {
    extend: {
      colors: {
        obsidian:  '#0A0A0A',
        charcoal:  '#121212',
        elevated:  '#1A1A1A',
        surface:   '#222222',
        border:    '#2A2A2A',
        gold:      '#D4AF37',
        'gold-light': '#E8CB6A',
        'gold-dark':  '#A8891F',
        platinum:  '#E8E8E8',
        champagne: '#F7E7CE',
        muted:     '#888888',
      },
      fontFamily: {
        display: ['Playfair Display', 'Georgia', 'serif'],
        sans:    ['Inter', 'system-ui', 'sans-serif'],
      },
      backgroundImage: {
        'gold-gradient':     'linear-gradient(135deg, #D4AF37 0%, #F5D469 50%, #A8891F 100%)',
        'dark-gradient':     'linear-gradient(180deg, #0A0A0A 0%, #121212 100%)',
        'card-gradient':     'linear-gradient(180deg, rgba(26,26,26,0) 60%, rgba(10,10,10,0.95) 100%)',
        'hero-gradient':     'linear-gradient(135deg, rgba(10,10,10,0.9) 0%, rgba(18,18,18,0.7) 100%)',
      },
      animation: {
        'shimmer':      'shimmer 2s linear infinite',
        'fade-up':      'fadeUp 0.6s ease-out forwards',
        'fade-in':      'fadeIn 0.4s ease-out forwards',
        'gold-pulse':   'goldPulse 3s ease-in-out infinite',
        'slide-left':   'slideLeft 0.5s ease-out forwards',
      },
      keyframes: {
        shimmer: {
          '0%':   { backgroundPosition: '-200% 0' },
          '100%': { backgroundPosition: '200% 0' },
        },
        fadeUp: {
          '0%':   { opacity: '0', transform: 'translateY(20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        fadeIn: {
          '0%':   { opacity: '0' },
          '100%': { opacity: '1' },
        },
        goldPulse: {
          '0%, 100%': { boxShadow: '0 0 20px rgba(212, 175, 55, 0.2)' },
          '50%':      { boxShadow: '0 0 40px rgba(212, 175, 55, 0.5)' },
        },
        slideLeft: {
          '0%':   { opacity: '0', transform: 'translateX(30px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
      },
      boxShadow: {
        'gold-sm':  '0 0 10px rgba(212, 175, 55, 0.15)',
        'gold-md':  '0 0 25px rgba(212, 175, 55, 0.25)',
        'gold-lg':  '0 0 50px rgba(212, 175, 55, 0.35)',
        'card':     '0 4px 32px rgba(0, 0, 0, 0.6)',
        'elevated': '0 8px 40px rgba(0, 0, 0, 0.8)',
      },
    },
  },
  plugins: [],
}

export default config
