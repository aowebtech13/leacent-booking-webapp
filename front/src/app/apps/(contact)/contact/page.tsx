import React from "react";
import ContactPage from "@/app/apps/(contact)/_components/ContactPage";
import type { Metadata } from "next";

export const dynamic = "force-static";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Contact Us - Business Labs - Books & Movies",
    description:
      "Get in touch with the Business Labs team. Send us a message and we will get back to you as soon as possible.",
    keywords: [
      "contact us",
      "contact",
      "support",
      "help",
      "customer service",
      "business labs",
    ],
    openGraph: {
      title: "Contact Us - Business Labs - Books & Movies",
      description:
        "Get in touch with the Business Labs team. Send us a message and we will get back to you as soon as possible.",
      url: "https://businesslab.leacent.org/apps/contact",
      siteName: "BUSINESS LAB - BOOKS & MOVIES",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <ContactPage />
    </div>
  );
};

export default Page;
