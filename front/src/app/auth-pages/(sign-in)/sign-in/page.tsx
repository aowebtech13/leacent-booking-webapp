import React from "react";
import SignInPage from "@/app/auth-pages/(sign-in)/_components/SignInPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Sign In - Business Labs - Books & Movies",
    description:
      "If you are looking for real-life investment, entrepreneurship, and business management resources, you are looking for Leacent's Business Lab Books - and Movies - brought to you by Firstborn Publishing. Securely sign in to your account with our user-friendly authentication system.",
    keywords: [
      "Leacent's Business Lab Books",
      "Firstborn Publishing",
      "investment resources",
      "entrepreneurship",
      "business management",
      "sign in",
      "login",
      "authentication",
      "react sign in",
      "UI sign in",
      "sign in component",
      "user authentication",
      "sign in customization",
      "sign in styles",
      "sign in effects",
      "sign in integration",
      "sign in library",
      "react auth",
      "sign in optimization",
      "sign in performance",
      "user login",
    ],
    openGraph: {
      title: "Sign In - Business Labs - Books & Movies",
      description:
        "If you are looking for real-life investment, entrepreneurship, and business management resources, you are looking for Leacent's Business Lab Books - and Movies - brought to you by Firstborn Publishing.",
      url: "https://businesslab.leacent.org/auth/sign-in",
      siteName: "BUSINESS LAB - BOOKS & MOVIES",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <SignInPage />
    </div>
  );
};

export default Page;
