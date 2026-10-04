import React from "react";
import WidgetsClient from "@/app/widgets/_components/WidgetsClient";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Widgets - Axelit",
    description:
      "Explore a collection of reusable widget components for your React application, including charts, statistics, and interactive elements.",
    keywords: [
      "widgets",
      "react components",
      "UI components",
      "widget components",
      "react widgets",
      "UI widgets",
      "component customization",
      "react optimization",
      "component performance",
      "widget design",
      "UI integration",
      "reusable components",
      "dashboard widgets",
      "interactive components",
    ],
    openGraph: {
      title: "Widgets - Axelit",
      description:
        "Explore a collection of reusable widget components for your React application, including charts, statistics, and interactive elements.",
      url: "https://axelit-next.vercel.app/widgets",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <WidgetsClient />
    </div>
  );
};

export default Page;
