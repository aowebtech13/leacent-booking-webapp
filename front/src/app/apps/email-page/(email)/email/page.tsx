import React from "react";
import EmailPage from "@/app/apps/email-page/(email)/_components/EmailPage";
import type { Metadata } from "next";

export const dynamic = "force-static";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Email - Axelit",
    description:
      "Explore advanced email interface and messaging features for your web applications.",
    keywords: [
      "email",
      "messaging",
      "email interface",
      "react email",
      "UI email",
      "email component",
      "email inbox",
      "email customization",
      "email styles",
      "email effects",
      "email integration",
      "email library",
      "react email app",
      "email optimization",
      "email performance",
    ],
    openGraph: {
      title: "Email - Axelit",
      description:
        "Explore advanced email interface and messaging features for your web applications.",
      url: "https://axelit-next.vercel.app/apps/email",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <EmailPage />
    </div>
  );
};

export default Page;
