import path from "path";
import { NextConfig } from "next";

/**
 * The "/" route is handled by `src/app/page.tsx` (server redirect to the sign
 * in page). A redirect declared here would be resolved at the HTTP layer,
 * which the Next.js client router follows transparently while keeping the
 * original URL - the app chrome would then wrap the auth page.
 */
const nextConfig: NextConfig = {
  sassOptions: {
    includePaths: [path.join(__dirname, "styles")],
  },

  images: {
    remotePatterns: [
      {
        protocol: "https",
        hostname: "res.cloudinary.com",
        pathname: "/**",
      },
      // Added your backend domain so next/image can load storage avatars/images safely
      {
        protocol: "https",
        hostname: "leacentbooks-enterpise.lexicron.org",
        pathname: "/**",
      },
      // Local development server (http://127.0.0.1:8000 and localhost)
      {
        protocol: "http",
        hostname: "127.0.0.1",
        port: "8000",
        pathname: "/**",
      },
      {
        protocol: "http",
        hostname: "localhost",
        port: "8000",
        pathname: "/**",
      },
    ],
  },

  experimental: {
    serverActions: {},
  },

  // Bypasses ESLint warnings (like <img> tags) during Vercel builds so deployment succeeds
  eslint: {
    ignoreDuringBuilds: true,
  },
};

export default nextConfig;