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
    default: "Business Labs - Books & Movies",
    template: "%s |Business Labs - Books & Movies",
  },
  description:
    " The Business Lab aims to build the capacity, competence, and confidence of business managers, potential entrepreneurs, and practicing small and medium-sized enterprises (SMEs)",
  keywords: [
    "Leacent Business Lab",
    "Project Diamond",
    "Leacent Entrepreneurial Movement",
    "• Leacent Incorporated",
    "Entrepreneurship Training Nigeria",
    "Enterprise Development Portal",
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
    siteName: "Leacent",
    title: "Business Labs - Books & Movies",
    description:
      "The Business Lab aims to build the capacity, competence, and confidence of business managers, potential entrepreneurs, and practicing small and medium-sized enterprises (SMEs)",
  },
  twitter: {
    card: "summary_large_image",
    title: "Business Labs - Books & Movies",
    description:
      "The Business Lab aims to build the capacity, competence, and confidence of business managers, potential entrepreneurs, and practicing small and medium-sized enterprises (SMEs)",
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
              defaultTitle="Business Labs - Books & Movies"
              blurTitle="👋🏻 Let's Study..."
            />
            {children}
          </DefaultLayout>
        </AuthProvider>
      </body>
    </html>
  );
}
