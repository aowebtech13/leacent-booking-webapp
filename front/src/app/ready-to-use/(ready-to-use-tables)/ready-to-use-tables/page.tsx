import React from "react";
import ReadyTouseTablePage from "@/app/ready-to-use/(ready-to-use-tables)/_components/ReadyTouseTablePage";
import type { Metadata } from "next";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Ready To Use Tables - Axelit",
    description:
      "Explore prebuilt tables like Patients, Students, Payments, Jobs, and Tickets.",
    keywords: [
      "admin dashboard",
      "data tables",
      "React Bootstrap",
      "Axelit",
      "responsive tables",
      "user management",
      "job listings",
      "ticketing system",
    ],
    openGraph: {
      title: "Ready To Use Tables - Axelit",
      description:
        "Prebuilt admin tables for managing patients, students, jobs, and more.",
      url: "https://axelit-next.vercel.app/ready-to-use/ready-to-use-tables",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <ReadyTouseTablePage />
    </div>
  );
};

export default Page;
