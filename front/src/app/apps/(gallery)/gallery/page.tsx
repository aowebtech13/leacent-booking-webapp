import React from "react";
import GalleryPage from "@/app/apps/(gallery)/_components/GalleryPage";
import type { Metadata } from "next";

export const dynamic = "force-static";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Gallery - Axelit",
    description:
      "Explore our image gallery with beautiful layouts and interactive features.",
    keywords: [
      "gallery",
      "image gallery",
      "photo gallery",
      "image viewer",
      "gallery layout",
      "image management",
      "photo viewer",
      "gallery grid",
      "image upload",
      "image sharing",
      "gallery filters",
      "image sorting",
      "gallery settings",
      "image optimization",
      "gallery customization",
    ],
    openGraph: {
      title: "Gallery - Axelit",
      description:
        "Explore our image gallery with beautiful layouts and interactive features.",
      url: "https://axelit-next.vercel.app/apps/gallery",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <GalleryPage />
    </div>
  );
};

export default Page;
