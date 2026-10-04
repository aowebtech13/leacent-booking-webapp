import React from "react";
import BootstrapSliderPage from "@/app/advance-ui/(bootstrap_slider)/_components/BootstrapSliderPage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Bootstrap Slider - Axelit",
    description:
      "Explore Bootstrap slider components for content carousels and image galleries in your React application.",
    keywords: [
      "bootstrap slider",
      "react components",
      "UI components",
      "content carousel",
      "image gallery",
      "react slider",
      "bootstrap components",
      "UI slider",
      "form slider",
      "slider input",
      "slider customization",
      "slider events",
      "slider styles",
      "slider integration",
      "bootstrap form controls",
    ],
    openGraph: {
      title: "Bootstrap Slider - Axelit",
      description:
        "Explore advanced slider components built with Bootstrap for your web applications.",
      url: "https://axelit-next.vercel.app/advance-ui/bootstrap-slider",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <BootstrapSliderPage />
    </div>
  );
};

export default Page;
