import React from "react";
import SitemapPage from "@/app/other-pages/(sitemap)/_components/SitemapPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Sitemap -Business Labs - Books & Movies",
    description:
      "Sitemap page template for organizing and displaying your React application's content structure.",
    keywords: [
      "sitemap",
      "react template",
      "UI template",
      "page template",
      "react components",
      "navigation page",
      "page customization",
      "template customization",
      "react optimization",
      "page performance",
      "sitemap design",
      "page structure",
      "template integration",
      "site navigation",
      "content organization",
    ],
    openGraph: {
      title: "Sitemap -Business Labs - Books & Movies",
      description:
        "Sitemap page template for organizing and displaying your React application's content structure.",
      url: "https://businesslab.leacent.org/other-pages/sitemap",
      siteName: "Leacent-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <SitemapPage />
    </div>
  );
};

export default Page;
