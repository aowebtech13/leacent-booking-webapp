import React from "react";
import AdvanceTablePage from "@/app/table/(advance-table)/_components/AdvanceTablePage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Advanced Tables - Axelit",
    description:
      "Explore advanced table components with enhanced features and customization options in your React application.",
    keywords: [
      "advanced tables",
      "react tables",
      "UI tables",
      "table components",
      "data display",
      "table customization",
      "react optimization",
      "table performance",
      "table design",
      "table integration",
      "table template",
      "table components",
      "data grid",
      "advanced features",
      "table customization",
      "table optimization",
    ],
    openGraph: {
      title: "Advanced Tables - Axelit",
      description:
        "Explore advanced table components with enhanced features and customization options in your React application.",
      url: "https://axelit-next.vercel.app/table/advance-table",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <AdvanceTablePage />
    </div>
  );
};

export default Page;
