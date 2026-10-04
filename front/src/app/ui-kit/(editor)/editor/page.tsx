import React from "react";
import EditorClient from "@/app/ui-kit/(editor)/_components/EditorClient";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Editor - Axelit",
    description:
      "Explore rich text editor components for content creation in your React application.",
    keywords: [
      "editor",
      "rich text editor",
      "react components",
      "UI components",
      "content creation",
      "react editor",
      "UI editor",
      "component customization",
      "react optimization",
      "component performance",
      "editor design",
      "UI integration",
      "text editor",
      "content editor",
      "rich text",
    ],
    openGraph: {
      title: "Editor - Axelit",
      description:
        "Explore rich text editor components for content creation in your React application.",
      url: "https://axelit-next.vercel.app/ui-kit/editor",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <EditorClient />
    </div>
  );
};

export default Page;
