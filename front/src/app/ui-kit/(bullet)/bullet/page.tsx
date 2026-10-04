import React from "react";
import BulletPage from "@/app/ui-kit/(bullet)/_components/BulletPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Bullet - Axelit",
    description:
      "Explore bullet components for decorative and highlight elements in your React application.",
    keywords: [
      "bullet",
      "react components",
      "UI components",
      "decorative elements",
      "highlight elements",
      "react bullet",
      "UI bullet",
      "component customization",
      "react optimization",
      "component performance",
      "bullet design",
      "UI integration",
      "decoration components",
      "highlight components",
    ],
    openGraph: {
      title: "Bullet - Axelit",
      description:
        "Explore bullet components for decorative and highlight elements in your React application.",
      url: "https://axelit-next.vercel.app/ui-kit/bullet",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <BulletPage />
    </div>
  );
};

export default Page;
