import React from "react";
import { Montserrat } from "next/font/google";
import type { Metadata, Viewport } from "next";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import "animate.css";
import "filepond/dist/filepond.min.css";
import "simplebar-react/dist/simplebar.min.css";
import "react-quill-new/dist/quill.snow.css";
import "bootstrap/dist/css/bootstrap.min.css";
import "select2/src/scss/_dropdown.scss";
import "select2/src/scss/_multiple.scss";
import "select2/src/scss/core.scss";
import "@/assets/scss/style.scss";
import "@/assets/css/style.css";
import "@/assets/scss/responsive.scss";
import "datatables.net-dt/css/dataTables.dataTables.css";
import "datatables.net-dt/css/dataTables.dataTables.min.css";
import DefaultLayout from "@/Component/Layouts/DefaultLayout";
import DocumentTitleManager from "@/Component/DocumentTitleManager";

const montserrat = Montserrat({
  subsets: ["latin"],
  weight: ["400", "500", "600", "700", "800", "900"],
  display: "swap",
  variable: "--font-montserrat",
});

export const viewport: Viewport = {
  width: "device-width",
  initialScale: 1,
  maximumScale: 1,
  userScalable: false,
  themeColor: "#ffffff",
};

export const metadata: Metadata = {
  title: {
    default: "Axelit - Premium Admin Template",
    template: "%s | Axelit",
  },
  description:
    "Multipurpose, super flexible, powerful, clean modern responsive bootstrap 5 admin template",
  keywords: [
    "admin template",
    "AXELIT admin template",
    "dashboard template",
    "flat admin template",
    "responsive admin template",
    "web app",
  ],
  icons: {
    icon: "/images/logo/favicon.png",
    shortcut: "/images/logo/favicon.png",
    apple: "/images/logo/favicon.png",
  },
  metadataBase: new URL(
    process.env.NEXT_PUBLIC_SITE_URL || "http://localhost:3000"
  ),
  openGraph: {
    type: "website",
    locale: "en_US",

    url: "/",
    siteName: "Axelit",
    title: "Axelit - Premium Admin Template",
    description:
      "Multipurpose, super flexible, powerful, clean modern responsive bootstrap 5 admin template",
  },
  twitter: {
    card: "summary_large_image",
    title: "Axelit - Premium Admin Template",
    description:
      "Multipurpose, super flexible, powerful, clean modern responsive bootstrap 5 admin template",
  },
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="en" className={`${montserrat.variable} font-sans`}>
      <head>
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"
          crossOrigin="anonymous"
        />
      </head>
      <body className="ltr light">
        <DefaultLayout>
          <DocumentTitleManager
            defaultTitle="Axelit - Premium Admin Template"
            blurTitle="👋🏻 Come Back..."
          />
          {children}
        </DefaultLayout>
      </body>
    </html>
  );
}
