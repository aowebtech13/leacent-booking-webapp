import React from "react";
import TablerIconPage from "@/app/icons/(tabler)/_components/TablerIconPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Tabler Icons - Axelit",
    description: "Explore the Tabler icon library for your React applications.",
    keywords: [
      "tabler icons",
      "react icons",
      "UI icons",
      "icon library",
      "react components",
      "icon customization",
      "icon effects",
      "icon integration",
      "react optimization",
      "icon performance",
      "icon customization",
      "icon styles",
      "icon customization",
    ],
    openGraph: {
      title: "Tabler Icons - Axelit",
      description:
        "Explore the Tabler icon library for your React applications.",
      url: "https://axelit-next.vercel.app/icons/tabler",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <TablerIconPage />
    </div>
  );
};

export default Page;
