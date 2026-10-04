import React from "react";
import ReadyToUseFormPage from "@/app/ready-to-use/(ready-to-use-form)/_components/ReadyToUseFormPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Ready to Use Form - Axelit",
    description:
      "Explore ready-to-use form templates with pre-configured components for your React application.",
    keywords: [
      "ready to use form",
      "react forms",
      "UI forms",
      "form components",
      "pre-configured form",
      "form validation",
      "form customization",
      "react optimization",
      "form performance",
      "form design",
      "form integration",
      "form template",
      "form components",
      "form library",
    ],
    openGraph: {
      title: "Ready to Use Form - Axelit",
      description:
        "Explore ready-to-use form templates with pre-configured components for your React application.",
      url: "https://axelit-next.vercel.app/ready-to-use/ready-to-use-form",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <ReadyToUseFormPage />
    </div>
  );
};

export default Page;
