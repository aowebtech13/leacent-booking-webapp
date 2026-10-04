import React from "react";
import CardsPage from "@/app/ui-kit/(cards)/_components/CardsPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Cards - Axelit",
    description:
      "Explore card components for content organization and display in your React application.",
    keywords: [
      "cards",
      "react components",
      "UI components",
      "content organization",
      "react card",
      "UI card",
      "component customization",
      "react optimization",
      "component performance",
      "card design",
      "UI integration",
      "content components",
      "display components",
    ],
    openGraph: {
      title: "Cards - Axelit",
      description:
        "Explore card components for content organization and display in your React application.",
      url: "https://axelit-next.vercel.app/ui-kit/cards",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <CardsPage />
    </div>
  );
};

export default Page;
