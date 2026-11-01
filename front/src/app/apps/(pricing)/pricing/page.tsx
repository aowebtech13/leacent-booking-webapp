import React from "react";
import PricingPage from "@/app/apps/(pricing)/_components/PricingPage";
import type { Metadata } from "next";

export const dynamic = "force-static";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Pricing -Business Labs - Books & Movies",
    description:
      "Discover our flexible pricing plans and features tailored for your needs.",
      keywords: [
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
      title: "Pricing -Business Labs - Books & Movies",
      description:
        "Discover our flexible pricing plans and features tailored for your needs.",
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
