import React from "react";
import MaintenancePage from "@/app/other-pages/(maintenance)/_components/MaintenancePage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Maintenance Page - Axelit",
    description:
      "Maintenance page template for temporary site downtime in your React application.",
    keywords: [
      "maintenance page",
      "react template",
      "UI template",
      "page template",
      "react components",
      "downtime page",
      "page customization",
      "template customization",
      "react optimization",
      "page performance",
      "maintenance design",
      "page structure",
      "template integration",
      "system maintenance",
    ],
    openGraph: {
      title: "Maintenance Page - Axelit",
      description:
        "Maintenance page template for temporary site downtime in your React application.",
      url: "https://axelit-next.vercel.app/other-pages/maintenance",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <MaintenancePage />
    </div>
  );
};

export default Page;
