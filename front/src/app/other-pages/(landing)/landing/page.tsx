import React from "react";
import LandingPage from "@/app/other-pages/(landing)/_components/LandingPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Landing Page - Axelit",
    description:
      "Modern and responsive landing page template for your React application.",
    keywords: [
      "landing page",
      "react template",
      "UI template",
      "page template",
      "react components",
      "homepage template",
      "page customization",
      "template customization",
      "react optimization",
      "page performance",
      "landing design",
      "page structure",
      "template integration",
      "marketing page",
    ],
    openGraph: {
      title: "Landing Page - Axelit",
      description:
        "Modern and responsive landing page template for your React application.",
      url: "https://axelit-next.vercel.app/other-pages/landing",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <LandingPage />
    </div>
  );
};

export default Page;
