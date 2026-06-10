"use client"

import { motion } from "framer-motion"
import { useTranslations } from "next-intl"
import { TestimonialsColumn, type Testimonial } from "@/components/ui/testimonials-columns"

const AVATARS = [
  "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&q=80",
  "https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&q=80",
  "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&q=80",
  "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=80&q=80",
  "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=80&q=80",
  "https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=80&q=80",
  "https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=80&q=80",
  "https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=80&q=80",
  "https://images.unsplash.com/photo-1463453091185-61582044d556?w=80&q=80",
]

export function TestimonialsSection() {
  const t = useTranslations("testimonials")
  const raw = t.raw("items") as Array<{ text: string; name: string; role: string }>

  const testimonials: Testimonial[] = raw.map((item, i) => ({
    text: item.text,
    name: item.name,
    role: item.role,
    image: AVATARS[i % AVATARS.length],
  }))

  const col1 = testimonials.slice(0, 3)
  const col2 = testimonials.slice(3, 6)
  const col3 = testimonials.slice(6, 9)

  return (
    <section className="bg-obsidian py-28 px-4 relative overflow-hidden">
      {/* Subtle radial glow */}
      <div className="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_60%_40%_at_50%_50%,rgba(212,175,55,0.04),transparent)]" />

      <div className="max-w-6xl mx-auto relative z-10">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.7 }}
          className="text-center mb-16"
        >
          <p className="text-gold text-[10px] tracking-[0.5em] uppercase mb-4">{t("eyebrow")}</p>
          <h2 className="font-display text-4xl md:text-5xl text-platinum font-light">
            {t("heading")}
          </h2>
          <div className="gold-rule" />
          <p className="text-muted text-sm mt-4">{t("sub")}</p>
        </motion.div>

        <div className="flex justify-center gap-4 mt-10 [mask-image:linear-gradient(to_bottom,transparent,black_20%,black_80%,transparent)] max-h-[680px] overflow-hidden">
          <TestimonialsColumn testimonials={col1} duration={18} />
          <TestimonialsColumn testimonials={col2} className="hidden md:block" duration={22} />
          <TestimonialsColumn testimonials={col3} className="hidden lg:block" duration={20} />
        </div>
      </div>
    </section>
  )
}
