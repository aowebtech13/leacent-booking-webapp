import React from "react";
import FilemanagerPage from "@/app/apps/(filemanager)/_components/FilemanagerPage";
import type { Metadata } from "next";

export const dynamic = "force-static";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "File Manager -Business Labs - Books & Movies",
    description:
      "Manage your files and documents with our intuitive file management system.",
    keywords: [
      "file manager",
      "document management",
      "file storage",
      "file organization",
      "file upload",
      "file sharing",
      "file preview",
      "document viewer",
      "file search",
      "file sync",
      "cloud storage",
      "file backup",
      "file permissions",
      "folder management",
      "file operations",
    ],
    openGraph: {
      title: "File Manager -Business Labs - Books & Movies",
      description:
        "Manage your files and documents with our intuitive file management system.",
      url: "https://businesslab.leacent.org/apps/file-manager",
      siteName: "Leacent-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <FilemanagerPage />
    </div>
  );
};

export default Page;
