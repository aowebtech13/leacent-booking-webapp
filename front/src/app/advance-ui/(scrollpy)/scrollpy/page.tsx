import React from "react";
import ScrollpyPage from "@/app/advance-ui/(scrollpy)/_components/ScrollpyPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Scrollpy -Business Labs - Books & Movies",
    description:
      "Explore advanced scroll effects and animations for your web applications.",
    keywords: [
      "scrollpy",
      "scroll effects",
      "scroll animations",
      "react scroll",
      "scroll component",
      "scroll behavior",
      "scroll events",
      "scroll triggers",
      "scroll animations",
      "scroll effects",
      "scroll customization",
      "scroll integration",
      "scroll library",
      "react scroll effects",
      "scroll performance",
      "scroll optimization",
    ],
    openGraph: {
      title: "Scrollpy -Business Labs - Books & Movies",
      description:
        "Explore advanced scroll effects and animations for your web applications.",
      url: "https://businesslab.leacent.org/",
      siteName: "BUSINESS LAB - BOOKS & MOVIES",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <ScrollpyPage />
    </div>
  );
};

export default Page;
