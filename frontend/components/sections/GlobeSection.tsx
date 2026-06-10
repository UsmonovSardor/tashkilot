"use client"

import { motion } from "framer-motion"
import { useTranslations } from "next-intl"
import { Globe } from "@/components/ui/cobe-globe"

const MARKERS = [
  { id: "tashkent",   location: [41.2995, 69.2401] as [number, number],  label: "Tashkent" },
  { id: "dubai",      location: [25.2048, 55.2708] as [number, number],  label: "Dubai" },
  { id: "london",     location: [51.5074, -0.1278] as [number, number],  label: "London" },
  { id: "singapore",  location: [1.3521,  103.8198] as [number, number], label: "Singapore" },
  { id: "moscow",     location: [55.7558, 37.6176] as [number, number],  label: "Moscow" },
  { id: "istanbul",   location: [41.0082, 28.9784] as [number, number],  label: "Istanbul" },
]

const ARCS = [
  { id: "tashkent-dubai",     from: [41.2995, 69.2401] as [number, number],  to: [25.2048, 55.2708] as [number, number] },
  { id: "dubai-london",       from: [25.2048, 55.2708] as [number, number],  to: [51.5074, -0.1278] as [number, number] },
  { id: "london-singapore",   from: [51.5074, -0.1278] as [number, number],  to: [1.3521,  103.8198] as [number, number] },
  { id: "tashkent-moscow",    from: [41.2995, 69.2401] as [number, number],  to: [55.7558, 37.6176] as [number, number] },
  { id: "istanbul-tashkent",  from: [41.0082, 28.9784] as [number, number],  to: [41.2995, 69.2401] as [number, number] },
]

export function GlobeSection() {
  const t = useTranslations("globe")

  return (
    <section className="relative py-24 bg-charcoal border-y border-border overflow-hidden">
      {/* Radial glow from globe */}
      <div className="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_50%_60%_at_70%_50%,rgba(212,175,55,0.06),transparent)]" />

      <div className="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">
        {/* Text */}
        <motion.div
          initial={{ opacity: 0, x: -30 }}
          whileInView={{ opacity: 1, x: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.8, ease: [0.22, 1, 0.36, 1] }}
          className="order-2 md:order-1"
        >
          <p className="text-gold text-[10px] tracking-[0.5em] uppercase mb-5">{t("eyebrow")}</p>
          <h2 className="font-display text-4xl md:text-5xl text-platinum font-light leading-tight mb-6">
            {t("heading")}
          </h2>
          <div className="flex items-center gap-3 mb-8">
            <div className="w-10 h-px bg-gold" />
            <div className="w-5 h-px bg-gold/40" />
          </div>
          <p className="text-muted text-base leading-relaxed max-w-md">{t("sub")}</p>

          <div className="mt-10 grid grid-cols-3 gap-6">
            {[
              { n: "6+",  l: "Cities" },
              { n: "3",   l: "Continents" },
              { n: "24/7", l: "Support" },
            ].map(({ n, l }) => (
              <div key={l} className="text-center">
                <p className="font-display text-2xl text-gold font-semibold">{n}</p>
                <p className="text-muted text-xs tracking-widest uppercase mt-1">{l}</p>
              </div>
            ))}
          </div>
        </motion.div>

        {/* Globe */}
        <motion.div
          initial={{ opacity: 0, scale: 0.9 }}
          whileInView={{ opacity: 1, scale: 1 }}
          viewport={{ once: true }}
          transition={{ duration: 1, ease: [0.22, 1, 0.36, 1] }}
          className="order-1 md:order-2 flex items-center justify-center"
        >
          <Globe
            markers={MARKERS}
            arcs={ARCS}
            className="w-full max-w-[480px] mx-auto"
            dark={1}
            mapBrightness={6}
            baseColor={[0.05, 0.05, 0.05]}
            markerColor={[0.83, 0.69, 0.22]}
            arcColor={[0.83, 0.69, 0.22]}
            glowColor={[0.1, 0.08, 0.02]}
            speed={0.004}
            diffuse={1.2}
          />
        </motion.div>
      </div>
    </section>
  )
}
