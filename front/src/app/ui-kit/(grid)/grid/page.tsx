import React from "react";
import GridPage from "@/app/ui-kit/(grid)/_components/GridPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Grid - Axelit",
    description:
      "Explore grid layout components for responsive and flexible layouts in your React application.",
    keywords: [
      "grid",
      "react components",
      "UI components",
      "layout components",
      "react grid",
      "UI grid",
      "component customization",
      "react optimization",
      "component performance",
      "grid design",
      "UI integration",
      "layout components",
      "responsive grid",
      "flexible layout",
    ],
    openGraph: {
      title: "Grid - Axelit",
      description:
        "Explore grid layout components for responsive and flexible layouts in your React application.",
      url: "https://axelit-next.vercel.app/ui-kit/grid",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <GridPage />
    </div>
  );
};

export default Page;
