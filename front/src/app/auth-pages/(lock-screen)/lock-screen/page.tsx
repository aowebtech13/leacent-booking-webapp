import React from "react";
import LockScreenPage from "@/app/auth-pages/(lock-screen)/_components/LockScreenPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Lock Screen -Business Labs - Books & Movies",
    description:
      "Secure your session with our user-friendly lock screen interface.",
    keywords: [
      "lock screen",
      "session lock",
      "security",
      "react lock screen",
      "UI lock screen",
      "lock screen component",
      "session security",
      "lock screen customization",
      "lock screen styles",
      "lock screen effects",
      "lock screen integration",
      "lock screen library",
      "react auth",
      "lock screen optimization",
      "lock screen performance",
      "session protection",
    ],
    openGraph: {
      title: "Lock Screen -Business Labs - Books & Movies",
      description:
        "Secure your session with our user-friendly lock screen interface.",
      url: "https://businesslab.leacent.org/auth/lock-screen",
      siteName: "Leacent-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <LockScreenPage />
    </div>
  );
};

export default Page;
