import React from "react";
import ContactPage from "@/app/apps/(contact)/_components/ContactPage";
import type { Metadata } from "next";

export const dynamic = "force-static";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Contact Us - Business Lab - Books & Movies",
    description:
      "Get in touch with the Business Lab team. Send us a message and we will get back to you as soon as possible.",
    keywords: [
      "contact us",
      "contact",
      "support",
      "help",
      "customer service",
      "Business Lab",
    ],
    openGraph: {
      title: "Contact Us - Business Lab - Books & Movies",
      description:
        "Get in touch with the Business Lab team. Send us a message and we will get back to you as soon as possible.",
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
