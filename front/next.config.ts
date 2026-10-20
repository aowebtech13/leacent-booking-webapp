import path from "path";
import { NextConfig } from "next";

/** @type {NextConfig} */
const nextConfig: NextConfig = {
  sassOptions: {
    includePaths: [path.join(__dirname, "styles")],
  },

  experimental: {
    serverActions: {}, // ✅ Fixed shape
  },
  // NOTE: the "/" route is handled by `src/app/page.tsx` (server redirect to
  // the sign in page). A redirect declared here would be resolved at the HTTP
  // layer, which the Next.js client router follows transparently while keeping
  // the original URL - the app chrome would then wrap the auth page.
};
  // async headers() {
  //   return [
  //     {
  //       source: "/images/:path*",
  //       headers: [
  //         {
  //           key: "Cache-Control",
  //           value: "public, max-age=3600, immutable",
  //         },
  //       ],
  //     },
  //     {
  //       source: "/image/:path*",
  //       headers: [
  //         {
  //           key: "Cache-Control",
  //           value: "public, max-age=3600, immutable",
  //         },
  //       ],
  //     },
  //     {
  //       source: "/:path*",
  //       headers: [
  //         {
  //           key: "Cache-Control",
  //           value: "public, max-age=3600, must-revalidate",
  //         },
  //       ],
  //     },
  //   ];
  // },
};

export default nextConfig;
