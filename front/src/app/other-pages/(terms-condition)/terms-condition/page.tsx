import React from "react";
import TermsPage from "@/app/other-pages/(terms-condition)/_components/TermsPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Terms & Conditions - Axelit",
    description:
      "Terms and conditions page template for your React application's legal terms and user agreements.",
    keywords: [
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
      title: "Terms & Conditions - Axelit",
      description:
        "Terms and conditions page template for your React application's legal terms and user agreements.",
      url: "https://axelit-next.vercel.app/other-pages/terms-condition",
      siteName: "Axelit-next",
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
