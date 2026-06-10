export default function VHLogo({ size = 28 }: { size?: number }) {
  return (
    <svg
      width={size}
      height={size}
      viewBox="0 0 28 28"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
      aria-label="Alpha Zone"
    >
      {/* Outer diamond */}
      <rect
        x="2" y="2" width="24" height="24"
        rx="0"
        transform="rotate(45 14 14)"
        stroke="url(#logoGold)"
        strokeWidth="0.8"
        fill="none"
      />
      {/* Inner diamond */}
      <rect
        x="5" y="5" width="18" height="18"
        transform="rotate(45 14 14)"
        stroke="url(#logoGold)"
        strokeWidth="0.4"
        fill="none"
        opacity="0.4"
      />
      {/* Corner dots */}
      <circle cx="14" cy="2"  r="0.8" fill="#D4AF37" />
      <circle cx="14" cy="26" r="0.8" fill="#D4AF37" />
      <circle cx="2"  cy="14" r="0.8" fill="#D4AF37" />
      <circle cx="26" cy="14" r="0.8" fill="#D4AF37" />

      <defs>
        <linearGradient id="logoGold" x1="0" y1="0" x2="28" y2="28" gradientUnits="userSpaceOnUse">
          <stop offset="0%"   stopColor="#D4AF37" />
          <stop offset="50%"  stopColor="#F5D469" />
          <stop offset="100%" stopColor="#A8891F" />
        </linearGradient>
      </defs>
    </svg>
  )
}
