import React from "react";
import SweetAlertPage from "@/app/advance-ui/(sweet_alert)/_components/SweetAlertPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Sweet Alert - Axelit",
    description:
      "Explore advanced alert components and notifications for your web applications.",
    keywords: [
      "sweet alert",
      "alert",
      "react alert",
      "notification",
      "alert component",
      "alert customization",
      "alert styles",
      "alert effects",
      "alert integration",
      "alert library",
      "react alert",
      "notification system",
      "alert animation",
      "alert optimization",
      "alert performance",
    ],
    openGraph: {
      title: "Sweet Alert - Axelit",
      description:
        "Explore advanced alert components and notifications for your web applications.",
      url: "https://axelit-next.vercel.app/advance-ui/sweet-alert",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <SweetAlertPage />
    </div>
  );
};

export default Page;
