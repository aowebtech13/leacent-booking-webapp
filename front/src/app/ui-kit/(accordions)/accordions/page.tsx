import React from "react";
import AccordionsPage from "@/app/ui-kit/(accordions)/_components/AccordionsPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Accordions - Axelit",
    description:
      "Explore accordion components for collapsible content sections in your React application.",
    keywords: [
      "accordions",
      "react components",
      "UI components",
      "collapsible content",
      "react accordion",
      "UI accordion",
      "content sections",
      "component customization",
      "react optimization",
      "component performance",
      "accordion design",
      "UI integration",
      "collapsible panels",
      "react components",
    ],
    openGraph: {
      title: "Accordions - Axelit",
      description:
        "Explore accordion components for collapsible content sections in your React application.",
      url: "https://axelit-next.vercel.app/ui-kit/accordions",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <AccordionsPage />
    </div>
  );
};

export default Page;
