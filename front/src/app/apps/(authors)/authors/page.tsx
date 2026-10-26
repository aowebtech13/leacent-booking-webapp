import React from "react";
import AuthorListPage from "@/app/apps/(authors)/_components/AuthorListPage";
import type { Metadata } from "next";

export const dynamic = "force-dynamic";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Authors - Business Labs - Books & Movies",
    description: "Browse our collection of authors and their books.",
    keywords: ["authors", "book authors", "writers", "book library"],
    openGraph: {
      title: "Authors - Business Labs - Books & Movies",
      description: "Browse our collection of authors and their books.",
      url: "https://businesslab.leacent.org/apps/authors",
      siteName: "BUSINESS LAB - BOOKS & MOVIES",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <AuthorListPage />
    </div>
  );
};

export default Page;
