import React from "react";
import IconoirPage from "@/app/icons/(iconoir)/_components/iconoirPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Iconoir Icons -Business Labs - Books & Movies",
    description:
      "Explore the Iconoir icon library for your React applications.",
    keywords: [
      "iconoir icons",
      "react icons",
      "UI icons",
      "icon library",
      "react components",
      "icon customization",
      "icon effects",
      "icon integration",
      "react optimization",
      "icon performance",
      "icon customization",
      "icon styles",
      "icon customization",
    ],
    openGraph: {
      title: "Iconoir Icons -Business Labs - Books & Movies",
      description:
        "Explore the Iconoir icon library for your React applications.",
      url: "https://businesslab.leacent.org/icons/iconoir",
      siteName: "BUSINESS LAB - BOOKS & MOVIES",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <IconoirPage />
    </div>
  );
};

export default Page;
