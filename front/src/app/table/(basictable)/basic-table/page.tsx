import React from "react";
import BasicTablePage from "@/app/table/(basictable)/_components/BasicTablePage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Basic Tables - Axelit",
    description:
      "Explore basic table components for displaying data in your React application.",
    keywords: [
      "basic tables",
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
      "table layout",
    ],
    openGraph: {
      title: "Basic Tables - Axelit",
      description:
        "Explore basic table components for displaying data in your React application.",
      url: "https://axelit-next.vercel.app/table/basic-table",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <BasicTablePage />
    </div>
  );
};

export default Page;
