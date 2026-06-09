import Link from 'next/link'

export default function Footer() {
  return (
    <footer className="bg-charcoal border-t border-border py-16 px-4">
      <div className="max-w-6xl mx-auto">
        <div className="grid md:grid-cols-4 gap-12 mb-16">
          {/* Brand */}
          <div className="md:col-span-2">
            <p className="font-display text-2xl mb-4">
              <span className="text-platinum">Velvet</span>
              <span className="text-gold italic">Hour</span>
            </p>
            <p className="text-muted text-sm leading-relaxed max-w-xs">
              The world's most exclusive concierge platform. Elite companions, curated venues, and a luxury fleet — all under one discreet roof.
            </p>
            <div className="mt-6 flex gap-1">
              <div className="w-8 h-px bg-gold" />
              <div className="w-4 h-px bg-gold/40" />
              <div className="w-2 h-px bg-gold/20" />
            </div>
          </div>

          {/* Services */}
          <div>
            <p className="text-platinum text-xs tracking-widest uppercase mb-6">Services</p>
            <div className="flex flex-col gap-3">
              {['Companion Matching', 'Venue Booking', 'Fleet & Chauffeur', 'Concierge Packages'].map((s) => (
                <span key={s} className="text-muted text-sm hover:text-gold cursor-pointer transition-colors">
                  {s}
                </span>
              ))}
            </div>
          </div>

          {/* Legal */}
          <div>
            <p className="text-platinum text-xs tracking-widest uppercase mb-6">Legal</p>
            <div className="flex flex-col gap-3">
              {['Privacy Policy', 'Terms of Service', 'NDA Policy', 'Escrow Terms'].map((s) => (
                <span key={s} className="text-muted text-sm hover:text-gold cursor-pointer transition-colors">
                  {s}
                </span>
              ))}
            </div>
          </div>
        </div>

        <div className="border-t border-border pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
          <p className="text-muted text-xs tracking-wider">
            © 2024 VelvetHour. All rights reserved. Discretion guaranteed.
          </p>
          <p className="text-muted/50 text-[10px] tracking-widest uppercase">
            Tashkent · Dubai · London · Singapore
          </p>
        </div>
      </div>
    </footer>
  )
}
