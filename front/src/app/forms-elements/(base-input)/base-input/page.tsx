import React from "react";
import BaseInputPage from "@/app/forms-elements/(base-input)/_components/BaseInputPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Base Input Forms - Axelit",
    description:
      "Explore various types of input fields and form controls for your React applications.",
    keywords: [
      "base input",
      "form inputs",
      "react forms",
      "UI forms",
      "form components",
      "input fields",
      "text inputs",
      "number inputs",
      "email inputs",
      "password inputs",
      "form customization",
      "form styles",
      "form integration",
      "react forms library",
      "form optimization",
      "form performance",
      "input validation",
    ],
    openGraph: {
      title: "Base Input Forms - Axelit",
      description:
        "Explore various types of input fields and form controls for your React applications.",
      url: "https://axelit-next.vercel.app/forms-elements/base-input",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <BaseInputPage />
    </div>
  );
};

export default Page;
