import React from "react";
import UnlockedBooksPage from "@/app/apps/(book-library)/_components/UnlockedBooksPage";
import type { Metadata } from "next";

export const dynamic = "force-dynamic";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "My Books (Unlocked) - Business Lab - Books & Movies",
    description:
      "View the list of books you have unlocked with points or a subscription and continue reading.",
    keywords: ["my books", "unlocked books", "library", "read books"],
    openGraph: {
      title: "My Books (Unlocked) - Business Lab - Books & Movies",
      description:
        "View the list of books you have unlocked and continue reading.",
      url: "https://businesslab.leacent.org/apps/book-library/unlocked",
      siteName: "BUSINESS LAB - BOOKS & MOVIES",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return <UnlockedBooksPage />;
};

export default Page;
