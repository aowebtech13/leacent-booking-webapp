import React from "react";
import ComingSoonPage from "@/app/other-pages/(coming-soon)/_components/ComingSoonPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Coming Soon - Axelit",
    description:
      "Coming soon page template for announcing new features or launches in your React application.",
    keywords: [
      "coming soon",
      "launch page",
      "react template",
      "UI template",
      "page template",
      "react components",
      "announcement page",
      "page customization",
      "template customization",
      "react optimization",
      "page performance",
      "launch design",
      "page structure",
      "template integration",
    ],
    openGraph: {
      title: "Coming Soon - Axelit",
      description:
        "Coming soon page template for announcing new features or launches in your React application.",
      url: "https://axelit-next.vercel.app/other-pages/coming-soon",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <ComingSoonPage />
    </div>
  );
};

export default Page;
