import React from "react";
import DividerPage from "@/app/ui-kit/(divider)/_components/DividerPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Dividers - Axelit",
    description:
      "Explore divider components for content separation and organization in your React application.",
    keywords: [
      "dividers",
      "react components",
      "UI components",
      "content separation",
      "react divider",
      "UI divider",
      "component customization",
      "react optimization",
      "component performance",
      "divider design",
      "UI integration",
      "separation components",
      "organizational components",
    ],
    openGraph: {
      title: "Dividers - Axelit",
      description:
        "Explore divider components for content separation and organization in your React application.",
      url: "https://axelit-next.vercel.app/ui-kit/divider",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <DividerPage />
    </div>
  );
};

export default Page;
