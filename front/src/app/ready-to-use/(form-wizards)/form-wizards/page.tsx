import React from "react";
import FormWizardsPage from "@/app/ready-to-use/(form-wizards)/_components/FormWizardsPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Form Wizards - Axelit",
    description:
      "Explore multiple form wizard templates for multi-step form handling in your React application.",
    keywords: [
      "form wizards",
      "react forms",
      "UI forms",
      "form components",
      "multi-step form",
      "form navigation",
      "form validation",
      "form customization",
      "react optimization",
      "form performance",
      "wizard design",
      "form integration",
      "step-by-step",
      "form wizard template",
    ],
    openGraph: {
      title: "Form Wizards - Axelit",
      description:
        "Explore multiple form wizard templates for multi-step form handling in your React application.",
      url: "https://axelit-next.vercel.app/ready-to-use/form-wizards",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <FormWizardsPage />
    </div>
  );
};

export default Page;
