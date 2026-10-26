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
import { AuthProvider } from "@/lib/contexts/AuthContext";

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
    default: "The Business Lab",
    template: "%s | The Business Lab",
  },
  description:
    "The Business Lab empowers entrepreneurs with strategic business development, technology integration, branding, and innovative solutions. Business Lab dedicated to transforming the capacity, competence, and confidence of entrepreneurs and business managers.",
  keywords: [
    "The Business Lab",
    "Business Development",
    "Entrepreneurship",
    "Technology Integration",
    "Branding",
    "Strategic Solutions",
  ],
  icons: {
    icon: "https://res.cloudinary.com/dqi7g7lky/image/upload/v1793002438/WhatsApp_Image_0008-10-26_at_01.07.28-removebg-preview-removebg-preview_giyzud.png",
    shortcut:
      "https://res.cloudinary.com/dqi7g7lky/image/upload/v1793002438/WhatsApp_Image_0008-10-26_at_01.07.28-removebg-preview-removebg-preview_giyzud.png",
    apple:
      "https://res.cloudinary.com/dqi7g7lky/image/upload/v1793002438/WhatsApp_Image_0008-10-26_at_01.07.28-removebg-preview-removebg-preview_giyzud.png",
  },
  metadataBase: new URL(
    process.env.NEXT_PUBLIC_SITE_URL || "http://localhost:3000"
  ),
  openGraph: {
    type: "website",
    locale: "en_US",

    url: "/",
    siteName: "The Business Lab",
    title: "The Business Lab",
    description:
      "The Business Lab empowers entrepreneurs with strategic business development, technology integration, branding, and innovative solutions. Business Lab dedicated to transforming the capacity, competence, and confidence of entrepreneurs and business managers.",
  },
  twitter: {
    card: "summary_large_image",
    title: "The Business Lab",
    description:
      "The Business Lab empowers entrepreneurs with strategic business development, technology integration, branding, and innovative solutions. Business Lab dedicated to transforming the capacity, competence, and confidence of entrepreneurs and business managers.",
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
      <body className="ltr light" suppressHydrationWarning>
        <AuthProvider>
          <DefaultLayout>
            <DocumentTitleManager
              defaultTitle="The Business Lab"
              blurTitle="👋🏻 Let's Study..."
            />
            {children}
          </DefaultLayout>
        </AuthProvider>
      </body>
    </html>
  );
}
