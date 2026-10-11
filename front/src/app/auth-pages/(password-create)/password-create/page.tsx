import React from "react";
import PasswordCreatePage from "@/app/auth-pages/(password-create)/_components/PasswordCreatePage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Create Password - Axelit",
    description:
      "Create a secure password for your account with our user-friendly password creation system.",
    keywords: [
      "create password",
      "password creation",
      "account setup",
      "react password",
      "UI password",
      "password component",
      "secure password",
      "password creation customization",
      "password styles",
      "password effects",
      "password integration",
      "password library",
      "react auth",
      "password optimization",
      "password performance",
      "account security",
    ],
    openGraph: {
      title: "Create Password - Axelit",
      description:
        "Create a secure password for your account with our user-friendly password creation system.",
      url: "https://axelit-next.vercel.app/auth/password-create",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <PasswordCreatePage />
    </div>
  );
};

export default Page;
