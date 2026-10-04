import React from "react";
import BlankPage from "@/app/other-pages/(blank)/_components/BlankPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Blank Page - Axelit",
    description:
      "A clean, minimal blank page template for building custom pages in your React application.",
    keywords: [
      "blank page",
      "react template",
      "UI template",
      "page template",
      "react components",
      "custom page",
      "page customization",
      "page layout",
      "template customization",
      "react optimization",
      "page performance",
      "template design",
      "page structure",
      "template integration",
    ],
    openGraph: {
      title: "Blank Page - Axelit",
      description:
        "A clean, minimal blank page template for building custom pages in your React application.",
      url: "https://axelit-next.vercel.app/other-pages/blank",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <BlankPage />
    </div>
  );
};

export default Page;
