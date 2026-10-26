import React from "react";
import ChartJsPage from "@/app/chart/(chart)/_components/ChartPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Chart.js -Business Labs - Books & Movies",
    description:
      "Explore interactive and customizable charts using Chart.js library for data visualization.",
    keywords: [
      "chart.js",
      "charts",
      "data visualization",
      "react charts",
      "UI charts",
      "chart component",
      "chart customization",
      "chart styles",
      "chart effects",
      "chart integration",
      "chart library",
      "react chart",
      "chart optimization",
      "chart performance",
      "data representation",
    ],
    openGraph: {
      title: "Chart.js -Business Labs - Books & Movies",
      description:
        "Explore interactive and customizable charts using Chart.js library for data visualization.",
      url: "https://businesslab.leacent.org/chart/chart-js",
      siteName: "BUSINESS LAB - BOOKS & MOVIES",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <ChartJsPage />
    </div>
  );
};

export default Page;
