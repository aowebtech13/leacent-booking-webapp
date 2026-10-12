import React from "react";
import PasswordResetPage from "@/app/auth-pages/(password-reset)/_components/PasswordResetPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Reset Password -Leacent Book-App",
    description:
      "Create a new password for your account using the reset link sent to your email.",
    keywords: [
      "reset password",
      "password reset",
      "new password",
      "authentication",
      "react reset password",
      "UI reset password",
      "reset password component",
      "user authentication",
    ],
    openGraph: {
      title: "Reset Password -Leacent Book-App",
      description:
        "Create a new password for your account using the reset link sent to your email.",
      url: "https://axelit-next.vercel.app/auth/reset-password",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <PasswordResetPage />
    </div>
  );
};

export default Page;
