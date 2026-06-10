"use client"

import { motion } from "framer-motion"
import { useTranslations } from "next-intl"
import { Sparkles } from "@/components/ui/sparkles"
import { InfiniteSlider } from "@/components/ui/infinite-slider"
import { ProgressiveBlur } from "@/components/ui/progressive-blur"

/* ── Partner logo SVGs ─────────────────────────────── */
const logos = [
  {
    id: "uzum",
    label: "Uzum Bank",
    svg: (
      <svg viewBox="0 0 120 40" fill="currentColor" className="h-7 w-auto opacity-50 hover:opacity-80 transition-opacity">
        <rect x="2" y="2" width="36" height="36" rx="8" fill="none" stroke="currentColor" strokeWidth="2"/>
        <text x="20" y="26" textAnchor="middle" fontSize="14" fontWeight="700" fontFamily="sans-serif">U</text>
        <text x="54" y="26" fontSize="14" fontWeight="600" fontFamily="sans-serif">Uzum</text>
        <text x="90" y="26" fontSize="11" fontFamily="sans-serif" opacity="0.7">Bank</text>
      </svg>
    ),
  },
  {
    id: "orient",
    label: "Orient Finance",
    svg: (
      <svg viewBox="0 0 130 40" fill="currentColor" className="h-7 w-auto opacity-50 hover:opacity-80 transition-opacity">
        <circle cx="20" cy="20" r="14" fill="none" stroke="currentColor" strokeWidth="2"/>
        <circle cx="20" cy="20" r="7" fill="currentColor" opacity="0.4"/>
        <text x="44" y="26" fontSize="14" fontWeight="600" fontFamily="sans-serif">Orient</text>
        <text x="97" y="26" fontSize="11" fontFamily="sans-serif" opacity="0.7">Finance</text>
      </svg>
    ),
  },
  {
    id: "silkroad",
    label: "Silk Road",
    svg: (
      <svg viewBox="0 0 120 40" fill="currentColor" className="h-7 w-auto opacity-50 hover:opacity-80 transition-opacity">
        <path d="M8 20 Q20 4 32 20 Q20 36 8 20Z" fill="none" stroke="currentColor" strokeWidth="1.5"/>
        <text x="44" y="18" fontSize="13" fontWeight="700" fontFamily="sans-serif">Silk</text>
        <text x="44" y="32" fontSize="13" fontWeight="700" fontFamily="sans-serif">Road</text>
      </svg>
    ),
  },
  {
    id: "nbu",
    label: "NBU",
    svg: (
      <svg viewBox="0 0 100 40" fill="currentColor" className="h-7 w-auto opacity-50 hover:opacity-80 transition-opacity">
        <rect x="2" y="8" width="24" height="24" rx="2" fill="none" stroke="currentColor" strokeWidth="2"/>
        <line x1="8" y1="8" x2="8" y2="32" stroke="currentColor" strokeWidth="1.5"/>
        <line x1="20" y1="8" x2="20" y2="32" stroke="currentColor" strokeWidth="1.5"/>
        <text x="36" y="26" fontSize="15" fontWeight="700" fontFamily="sans-serif" letterSpacing="2">NBU</text>
      </svg>
    ),
  },
  {
    id: "nexus",
    label: "Nexus",
    svg: (
      <svg viewBox="0 0 110 40" fill="currentColor" className="h-7 w-auto opacity-50 hover:opacity-80 transition-opacity">
        <polygon points="20,4 36,14 36,26 20,36 4,26 4,14" fill="none" stroke="currentColor" strokeWidth="1.5"/>
        <polygon points="20,11 29,17 29,23 20,29 11,23 11,17" fill="currentColor" opacity="0.2"/>
        <text x="46" y="26" fontSize="15" fontWeight="600" fontFamily="sans-serif">Nexus</text>
      </svg>
    ),
  },
  {
    id: "meridian",
    label: "Meridian",
    svg: (
      <svg viewBox="0 0 130 40" fill="currentColor" className="h-7 w-auto opacity-50 hover:opacity-80 transition-opacity">
        <path d="M4 20 A16 16 0 0 1 36 20" fill="none" stroke="currentColor" strokeWidth="2"/>
        <line x1="20" y1="4" x2="20" y2="36" stroke="currentColor" strokeWidth="1.5" strokeDasharray="3 2"/>
        <text x="46" y="26" fontSize="13" fontWeight="600" fontFamily="sans-serif">Meridian</text>
      </svg>
    ),
  },
  {
    id: "sovereign",
    label: "Sovereign",
    svg: (
      <svg viewBox="0 0 130 40" fill="currentColor" className="h-7 w-auto opacity-50 hover:opacity-80 transition-opacity">
        <path d="M20 4 L34 12 L34 24 L20 32 L6 24 L6 12 Z" fill="none" stroke="currentColor" strokeWidth="1.5"/>
        <path d="M20 10 L28 15 L28 22 L20 27 L12 22 L12 15 Z" fill="currentColor" opacity="0.15"/>
        <text x="44" y="26" fontSize="13" fontWeight="600" fontFamily="sans-serif">Sovereign</text>
      </svg>
    ),
  },
  {
    id: "prestij",
    label: "Prestij",
    svg: (
      <svg viewBox="0 0 110 40" fill="currentColor" className="h-7 w-auto opacity-50 hover:opacity-80 transition-opacity">
        <rect x="6" y="6" width="28" height="28" rx="4" fill="none" stroke="currentColor" strokeWidth="1.5"/>
        <rect x="11" y="11" width="18" height="18" rx="2" fill="currentColor" opacity="0.2"/>
        <text x="44" y="26" fontSize="14" fontWeight="600" fontFamily="sans-serif">Prestij</text>
      </svg>
    ),
  },
]

export function PartnersSection() {
  const t = useTranslations("partners")

  return (
    <section className="relative overflow-hidden bg-obsidian py-24">
      {/* Sparkles background */}
      <Sparkles
        density={500}
        color="#D4AF37"
        opacity={0.4}
        size={0.8}
        speed={0.4}
        className="pointer-events-none absolute inset-x-0 top-0 h-full w-full [mask-image:radial-gradient(60%_60%_at_50%_0%,white,transparent)]"
      />

      <div className="relative z-10 max-w-6xl mx-auto px-4">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.7 }}
          className="text-center mb-14"
        >
          <p className="text-gold text-[10px] tracking-[0.5em] uppercase mb-4">{t("eyebrow")}</p>
          <h2 className="font-display text-3xl md:text-4xl text-platinum font-light mb-3">
            {t("heading")}
          </h2>
          <div className="gold-rule" />
          <p className="text-muted text-sm max-w-xl mx-auto mt-4 leading-relaxed">{t("sub")}</p>
        </motion.div>

        {/* Logo slider */}
        <div className="relative h-20 w-full">
          <InfiniteSlider
            className="flex h-full w-full items-center"
            duration={35}
            gap={56}
          >
            {logos.map(({ id, svg }) => (
              <div key={id} className="text-platinum/60 hover:text-gold transition-colors cursor-default">
                {svg}
              </div>
            ))}
          </InfiniteSlider>
          <ProgressiveBlur
            className="pointer-events-none absolute top-0 left-0 h-full w-[160px]"
            direction="left"
            blurIntensity={0.8}
          />
          <ProgressiveBlur
            className="pointer-events-none absolute top-0 right-0 h-full w-[160px]"
            direction="right"
            blurIntensity={0.8}
          />
        </div>
      </div>
    </section>
  )
}
