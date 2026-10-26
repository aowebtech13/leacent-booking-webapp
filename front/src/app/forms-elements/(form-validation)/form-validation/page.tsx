import React from "react";
import FormValidationPage from "@/app/forms-elements/(form-validation)/_components/FormValidationPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Form Validation -Business Labs - Books & Movies",
    description:
      "Explore form validation components and techniques for ensuring data integrity in your React forms.",
    keywords: [
      "form validation",
      "form inputs",
      "react forms",
      "UI forms",
      "form components",
      "data validation",
      "form rules",
      "validation customization",
      "form styles",
      "form integration",
      "react forms library",
      "form optimization",
      "form performance",
      "validation patterns",
      "error handling",
    ],
    openGraph: {
      title: "Form Validation -Business Labs - Books & Movies",
      description:
        "Explore form validation components and techniques for ensuring data integrity in your React forms.",
      url: "https://businesslab.leacent.org/forms-elements/form-validation",
      siteName: "BUSINESS LAB - BOOKS & MOVIES",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <FormValidationPage />
    </div>
  );
};

export default Page;
