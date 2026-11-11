import React from "react";
import BookReaderPage from "@/app/apps/(book-library)/_components/BookReaderPage";
import type { Metadata } from "next";

export const dynamic = "force-dynamic";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Read Book - Business Labs - Books & Movies",
    description: "Read a book from your library.",
  };
}

const Page = () => {
  return <BookReaderPage />;
};

export default Page;
