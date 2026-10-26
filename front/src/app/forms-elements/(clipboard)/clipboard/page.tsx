import React from "react";
import ClipboardPage from "@/app/forms-elements/(clipboard)/_components/ClipboardPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Clipboard Forms -Business Labs - Books & Movies",
    description:
      "Explore clipboard integration components for copying and pasting text in your React forms.",
    keywords: [
      "clipboard",
      "copy paste",
      "form inputs",
      "react forms",
      "UI forms",
      "form components",
      "clipboard integration",
      "clipboard customization",
      "form styles",
      "form integration",
      "react forms library",
      "form optimization",
      "form performance",
      "clipboard functionality",
      "text copying",
    ],
    openGraph: {
      title: "Clipboard Forms -Business Labs - Books & Movies",
      description:
        "Explore clipboard integration components for copying and pasting text in your React forms.",
      url: "https://businesslab.leacent.org/forms-elements/clipboard",
      siteName: "Leacent-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <ClipboardPage />
    </div>
  );
};

export default Page;
