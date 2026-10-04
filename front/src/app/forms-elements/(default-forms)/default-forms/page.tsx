import React from "react";
import DefaultFormsPage from "@/app/forms-elements/(default-forms)/_components/DefaultFormsPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Default Forms - Axelit",
    description:
      "Explore default form components and layouts for your React applications.",
    keywords: [
      "default forms",
      "form inputs",
      "react forms",
      "UI forms",
      "form components",
      "form layout",
      "form customization",
      "form styles",
      "form integration",
      "react forms library",
      "form optimization",
      "form performance",
      "form validation",
      "form handling",
    ],
    openGraph: {
      title: "Default Forms - Axelit",
      description:
        "Explore default form components and layouts for your React applications.",
      url: "https://axelit-next.vercel.app/forms-elements/default-forms",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <DefaultFormsPage />
    </div>
  );
};

export default Page;
