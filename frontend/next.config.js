const createNextIntlPlugin = require('next-intl/plugin')

const withNextIntl = createNextIntlPlugin('./i18n.ts')

/** @type {import('next').NextConfig} */
const nextConfig = {
  images: {
    remotePatterns: [
      { protocol: 'https', hostname: 'images.unsplash.com' },
      { protocol: 'https', hostname: '**.cloudinary.com' },
      { protocol: 'https', hostname: 'randomuser.me' },
    ],
  },
  eslint: { ignoreDuringBuilds: true },
  typescript: { ignoreBuildErrors: true },
  transpilePackages: [
    'cobe',
    '@tsparticles/react',
    '@tsparticles/slim',
    '@tsparticles/engine',
    '@tsparticles/updater-opacity',
    '@tsparticles/updater-size',
    '@tsparticles/move-base',
    '@tsparticles/plugin-emitter',
    'react-use-measure',
  ],
  experimental: {
    esmExternals: false,
  },
}

module.exports = withNextIntl(nextConfig)
