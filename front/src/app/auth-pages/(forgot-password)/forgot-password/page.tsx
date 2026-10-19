import React from "react";
import ForgotPasswordPage from "@/app/auth-pages/(forgot-password)/_components/ForgotPasswordPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Forgot Password -Leacent Book-App",
    description:
      "Request a password reset link to be sent to your email address.",
    keywords: [
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
      title: "Forgot Password -Leacent Book-App",
      description:
        "Request a password reset link to be sent to your email address.",
      url: "https://axelit-next.vercel.app/auth/forgot-password",
      siteName: "Axelit-next",
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
