import React from "react";
import BookLibraryPage from "@/app/apps/(book-library)/_components/BookLibraryPage";
import type { Metadata } from "next";

export const dynamic = "force-dynamic";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Book Library -Business Lab - Books & Movies",
    description:
      "If you are looking for real-life investment, entrepreneurship, and business management resources, you are looking for Leacent's Business Lab Books - and Movies - brought to you by Firstborn Publishing. Browse and read your e-book library. Access EPUB, MOBI, KF8 (AZW3), FB2, CBZ, and PDF formats.",
    keywords: [
      "Leacent's Business Lab Books",
      "Firstborn Publishing",
      "investment resources",
      "entrepreneurship",
      "business management",
      "book library",
      "ebook",
      "reader",
      "epub",
      "mobi",
      "e-book",
      "reading",
      "books",
    ],
    openGraph: {
      title: "Book Library -Business Lab - Books & Movies",
      description:
        "If you are looking for real-life investment, entrepreneurship, and business management resources, you are looking for Leacent's Business Lab Books - and Movies - brought to you by Firstborn Publishing.",
      url: "https://businesslab.leacent.org/apps/book-library",
      siteName: "BUSINESS LAB - BOOKS & MOVIES",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <BookLibraryPage />
    </div>
  );
};

export default Page;
