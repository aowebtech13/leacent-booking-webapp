import React from "react";
import VideoEmbedPage from "@/app/advance-ui/(video_embed)/_components/VideoEmbedPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Video Embed - Axelit",
    description:
      "Explore advanced video embedding components and media integration for your web applications.",
    keywords: [
      "video embed",
      "media embedding",
      "react video",
      "UI video",
      "video component",
      "media integration",
      "video customization",
      "video styles",
      "video effects",
      "video integration",
      "video library",
      "react video player",
      "video optimization",
      "video performance",
      "media player",
    ],
    openGraph: {
      title: "Video Embed - Axelit",
      description:
        "Explore advanced video embedding components and media integration for your web applications.",
      url: "https://axelit-next.vercel.app/advance-ui/video-embed",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <VideoEmbedPage />
    </div>
  );
};

export default Page;
