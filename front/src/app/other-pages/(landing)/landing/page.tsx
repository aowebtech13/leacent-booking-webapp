import React from "react";
import LandingPage from "@/app/other-pages/(landing)/_components/LandingPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Landing Page -Business Lab - Books & Movies",
    description:
      "If you are looking for real-life investment, entrepreneurship, and business management resources, you are looking for Leacent's Business Lab Books - and Movies - brought to you by Firstborn Publishing. Modern and responsive landing page template for your React application.",
    keywords: [
      "Leacent's Business Lab Books",
      "Firstborn Publishing",
      "investment resources",
      "entrepreneurship",
      "business management",
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
      title: "Landing Page -Business Lab - Books & Movies",
      description:
        "If you are looking for real-life investment, entrepreneurship, and business management resources, you are looking for Leacent's Business Lab Books - and Movies - brought to you by Firstborn Publishing.",
      url: "https://businesslab.leacent.org/other-pages/landing",
      siteName: "BUSINESS LAB - BOOKS & MOVIES",
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
