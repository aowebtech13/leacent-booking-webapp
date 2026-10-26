import React from "react";
import SettingPage from "@/app/apps/(setting)/_components/SettingPage";
import type { Metadata } from "next";

export const dynamic = "force-static";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Settings -Business Labs - Books & Movies",
    description:
      "Configure and customize your application settings with our advanced settings management system.",
    keywords: [
      "settings",
      "configuration",
      "react settings",
      "UI settings",
      "settings component",
      "application settings",
      "settings customization",
      "settings styles",
      "settings effects",
      "settings integration",
      "settings library",
      "react settings app",
      "settings optimization",
      "settings performance",
      "preferences",
      "configuration management",
    ],
    openGraph: {
      title: "Settings -Business Labs - Books & Movies",
      description:
        "Configure and customize your application settings with our advanced settings management system.",
      url: "https://businesslab.leacent.org/apps/settings",
      siteName: "Leacent-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <SettingPage />
    </div>
  );
};

export default Page;
