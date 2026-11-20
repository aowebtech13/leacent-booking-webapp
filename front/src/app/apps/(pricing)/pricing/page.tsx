import React from "react";
import PricingPage from "@/app/apps/(pricing)/_components/PricingPage";
import type { Metadata } from "next";

export const dynamic = "force-static";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Pricing -Business Lab - Books & Movies",
    description:
      "If you are looking for real-life investment, entrepreneurship, and business management resources, you are looking for Leacent's Business Lab Books - and Movies - brought to you by Firstborn Publishing. Discover our flexible pricing plans and features tailored for your needs.",
    keywords: [
      "Leacent's Business Lab Books",
      "Firstborn Publishing",
      "investment resources",
      "entrepreneurship",
      "business management",
      "pricing",
      "point packages",
      "pricing tiers",
      "cost calculator",
      "pricing comparison",
      "features",
      "pricing table",
      "point packs",
      "pricing options",
      "value proposition",
      "plan comparison",
      "pricing structure",
      "pricing benefits",
    ],
    openGraph: {
      title: "Pricing -Business Lab - Books & Movies",
      description:
        "If you are looking for real-life investment, entrepreneurship, and business management resources, you are looking for Leacent's Business Lab Books - and Movies - brought to you by Firstborn Publishing.",
      url: "https://businesslab.leacent.org/apps/pricing",
      siteName: "BUSINESS LAB - BOOKS & MOVIES",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <PricingPage />
    </div>
  );
};

export default Page;
