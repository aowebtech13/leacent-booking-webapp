import React from "react";
import ForgotPasswordPage from "@/app/auth-pages/(forgot-password)/_components/ForgotPasswordPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Forgot Password -Business Labs - Books & Movies",
    description:
      "If you are looking for real-life investment, entrepreneurship, and business management resources, you are looking for Leacent's Business Lab Books - and Movies - brought to you by Firstborn Publishing. Request a password reset link to be sent to your email address.",
    keywords: [
      "Leacent's Business Lab Books",
      "Firstborn Publishing",
      "investment resources",
      "entrepreneurship",
      "business management",
      "forgot password",
      "password reset",
      "reset password",
      "authentication",
      "react forgot password",
      "UI forgot password",
      "forgot password component",
      "user authentication",
    ],
    openGraph: {
      title: "Forgot Password -Business Labs - Books & Movies",
      description:
        "If you are looking for real-life investment, entrepreneurship, and business management resources, you are looking for Leacent's Business Lab Books - and Movies - brought to you by Firstborn Publishing.",
      url: "https://businesslab.leacent.org/auth/forgot-password",
      siteName: "BUSINESS LAB - BOOKS & MOVIES",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <ForgotPasswordPage />
    </div>
  );
};

export default Page;
