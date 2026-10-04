import React from "react";
import ApiPage from "@/app/apps/(api)/_components/ApiPage";
import type { Metadata } from "next";

export const dynamic = "force-static";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "API - Axelit",
    description:
      "Explore our comprehensive API documentation and integration options for developers.",
    keywords: [
      "API documentation",
      "REST API",
      "API endpoints",
      "API integration",
      "developer tools",
      "API reference",
      "API documentation",
      "API endpoints",
      "API integration",
      "developer tools",
      "API reference",
      "API documentation",
      "API endpoints",
      "API integration",
      "developer tools",
      "API reference",
    ],
    openGraph: {
      title: "API - Axelit",
      description:
        "Comprehensive API documentation and integration options for developers.",
      url: "https://axelit-next.vercel.app/apps/api",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return <ApiPage />;
};

export default Page;
