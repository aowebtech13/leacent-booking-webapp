import React from "react";
import BackgroundPage from "@/app/ui-kit/(background)/_components/BackgroundPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Backgrounds - Axelit",
    description:
      "Explore background components and styles for your React application's UI elements.",
    keywords: [
      "backgrounds",
      "react components",
      "UI components",
      "background styles",
      "react background",
      "UI background",
      "component customization",
      "react optimization",
      "component performance",
      "background design",
      "UI integration",
      "visual components",
      "styling components",
    ],
    openGraph: {
      title: "Backgrounds - Axelit",
      description:
        "Explore background components and styles for your React application's UI elements.",
      url: "https://axelit-next.vercel.app/ui-kit/background",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <BackgroundPage />
    </div>
  );
};

export default Page;
