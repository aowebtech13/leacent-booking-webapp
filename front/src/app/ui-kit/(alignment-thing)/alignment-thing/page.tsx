import React from "react";
import AlignmentThingPage from "@/app/ui-kit/(alignment-thing)/_components/AlignmentThingPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Alignment - Axelit",
    description:
      "Explore alignment components for precise content positioning in your React application.",
    keywords: [
      "alignment",
      "react components",
      "UI components",
      "content alignment",
      "positioning",
      "react alignment",
      "UI alignment",
      "component customization",
      "react optimization",
      "component performance",
      "alignment design",
      "UI integration",
      "positioning components",
      "layout components",
    ],
    openGraph: {
      title: "Alignment - Axelit",
      description:
        "Explore alignment components for precise content positioning in your React application.",
      url: "https://axelit-next.vercel.app/ui-kit/alignment-thing",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <AlignmentThingPage />
    </div>
  );
};

export default Page;
