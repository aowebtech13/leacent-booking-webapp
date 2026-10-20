import React from "react";
import ResetPasswordPage from "@/app/auth-pages/(reset-password)/_components/ResetPasswordPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Reset Password - Leacent Book-App",
    description: "Choose a new password for your Leacent account.",
    keywords: [
      "reset password",
      "new password",
      "password reset",
      "authentication",
    ],
    openGraph: {
      title: "Reset Password - Leacent Book-App",
      description: "Choose a new password for your Leacent account.",
      url: "https://axelit-next.vercel.app/auth-pages/reset-password",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <ResetPasswordPage />
    </div>
  );
};

export default Page;
