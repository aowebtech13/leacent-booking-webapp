import React from "react";
import BookLibraryPage from "@/app/apps/(book-library)/_components/BookLibraryPage";
import type { Metadata } from "next";

export const dynamic = "force-dynamic";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Book Library -Business Labs - Books & Movies",
    description:
      "Browse and read your e-book library. Access EPUB, MOBI, KF8 (AZW3), FB2, CBZ, and PDF formats.",
    keywords: [
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
      title: "Book Library -Business Labs - Books & Movies",
      description:
        "Browse and read your e-book library with our built-in reader.",
      url: "https://businesslab.leacent.org/apps/book-library",
      siteName: "Leacent-next",
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
