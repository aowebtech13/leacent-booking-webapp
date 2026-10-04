import React from "react";
import ProfilePage from "@/app/apps/(profile)/_components/ProfilePage";
import type { Metadata } from "next";

export const dynamic = "force-static";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Profile - Axelit",
    description:
      "Manage your profile settings, update personal information, and customize your dashboard preferences.",
    keywords: [
      "profile settings",
      "user management",
      "dashboard customization",
      "Axelit",
      "user profile",
      "account settings",
      "personal information",
      "preferences",
    ],
    openGraph: {
      title: "Profile - Axelit",
      description:
        "Manage your profile settings and preferences in Axelit dashboard.",
      url: "https://axelit-next.vercel.app/apps/profile",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return <ProfilePage />;
};
export default Page;
