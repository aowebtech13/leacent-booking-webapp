import React from "react";
import ScrollbarPage from "@/app/advance-ui/(scrollbar)/_components/ScrollbarPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Scrollbar - Axelit",
    description:
      "Explore advanced scrollbar components and custom scrollbars for your web applications.",
    keywords: [
      "scrollbar",
      "custom scrollbar",
      "react scrollbar",
      "scroll component",
      "scroll customization",
      "scroll styles",
      "scroll behavior",
      "scroll effects",
      "scroll integration",
      "scroll library",
      "react scroll",
      "scroll animation",
      "scroll optimization",
      "scroll performance",
      "scroll customization",
    ],
    openGraph: {
      title: "Scrollbar - Axelit",
      description:
        "Explore advanced scrollbar components and custom scrollbars for your web applications.",
      url: "https://axelit-next.vercel.app/advance-ui/scrollbar",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <ScrollbarPage />
    </div>
  );
};

export default Page;
