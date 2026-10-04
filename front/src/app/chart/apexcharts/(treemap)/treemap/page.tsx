import React from "react";
import TreemapChartPage from "@/app/chart/apexcharts/(treemap)/_components/TreemapChartPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Treemap Chart - ApexCharts - Axelit",
    description:
      "Explore interactive treemap charts using ApexCharts for hierarchical data visualization.",
    keywords: [
      "treemap chart",
      "apexcharts",
      "charts",
      "data visualization",
      "react charts",
      "UI charts",
      "chart component",
      "treemap customization",
      "hierarchical data",
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
      title: "Treemap Chart - ApexCharts - Axelit",
      description:
        "Explore interactive treemap charts using ApexCharts for hierarchical data visualization.",
      url: "https://axelit-next.vercel.app/chart/apexcharts/treemap",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <TreemapChartPage />
    </div>
  );
};

export default Page;
