import React from "react";
import FaqPage from "@/app/apps/(faq)/_components/FaqPage";
import type { Metadata } from "next";

export const dynamic = "force-static";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "FAQ -Business Labs - Books & Movies",
    description:
      "Find answers to common questions about our platform, features, and usage.",
    keywords: [
      "FAQ",
      "frequently asked questions",
      "help center",
      "support",
      "documentation",
      "user guide",
      "troubleshooting",
      "platform features",
      "usage guide",
      "technical support",
      "customer support",
      "help documentation",
      "support center",
      "user questions",
    ],
    openGraph: {
      title: "FAQ -Business Labs - Books & Movies",
      description:
        "Find answers to frequently asked questions and get support for your web applications.",
      url: "https://businesslab.leacent.org/apps/faq",
      siteName: "Leacent-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <FaqPage />
    </div>
  );
};

export default Page;
