import React from "react";
import TermsPage from "@/app/other-pages/(terms-condition)/_components/TermsPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Terms & Conditions -Business Labs - Books & Movies",
    description:
      "If you are looking for real-life investment, entrepreneurship, and business management resources, you are looking for Leacent's Business Lab Books - and Movies - brought to you by Firstborn Publishing. Terms and conditions page template for your React application's legal terms and user agreements.",
    keywords: [
      "Leacent's Business Lab Books",
      "Firstborn Publishing",
      "investment resources",
      "entrepreneurship",
      "business management",
      "terms and conditions",
      "react template",
      "UI template",
      "page template",
      "react components",
      "legal page",
      "page customization",
      "template customization",
      "react optimization",
      "page performance",
      "terms design",
      "page structure",
      "template integration",
      "user agreement",
      "legal terms",
    ],
    openGraph: {
      title: "Terms & Conditions -Business Labs - Books & Movies",
      description:
        "If you are looking for real-life investment, entrepreneurship, and business management resources, you are looking for Leacent's Business Lab Books - and Movies - brought to you by Firstborn Publishing.",
      url: "https://businesslab.leacent.org/other-pages/terms-condition",
      siteName: "BUSINESS LAB - BOOKS & MOVIES",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <TermsPage />
    </div>
  );
};

export default Page;
