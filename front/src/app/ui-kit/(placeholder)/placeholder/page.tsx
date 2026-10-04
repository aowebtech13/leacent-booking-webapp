import React from "react";
import PlaceholderPage from "@/app/ui-kit/(placeholder)/components/PlaceholderPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Placeholder - Axelit",
    description:
      "Explore placeholder components for loading states and content placeholders in your React application.",
    keywords: [
      "placeholder",
      "react components",
      "UI components",
      "loading states",
      "content placeholders",
      "react placeholder",
      "UI placeholder",
      "component customization",
      "react optimization",
      "component performance",
      "placeholder design",
      "UI integration",
      "loading components",
      "content skeleton",
    ],
    openGraph: {
      title: "Placeholder - Axelit",
      description:
        "Explore placeholder components for loading states and content placeholders in your React application.",
      url: "https://axelit-next.vercel.app/ui-kit/placeholder",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <PlaceholderPage />
    </div>
  );
};

export default Page;
