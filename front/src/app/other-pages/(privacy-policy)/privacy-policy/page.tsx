import React from "react";
import PrivacyPolicyPage from "@/app/other-pages/(privacy-policy)/_components/PrivacyPolicyPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Privacy Policy - Axelit",
    description:
      "Privacy policy page template for your React application's data protection and user privacy information.",
    keywords: [
      "privacy policy",
      "react template",
      "UI template",
      "page template",
      "react components",
      "legal page",
      "page customization",
      "template customization",
      "react optimization",
      "page performance",
      "privacy design",
      "page structure",
      "template integration",
      "data protection",
      "user privacy",
    ],
    openGraph: {
      title: "Privacy Policy - Axelit",
      description:
        "Privacy policy page template for your React application's data protection and user privacy information.",
      url: "https://axelit-next.vercel.app/other-pages/privacy-policy",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <PrivacyPolicyPage />
    </div>
  );
};

export default Page;
