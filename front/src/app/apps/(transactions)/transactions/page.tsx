import React from "react";
import TransactionHistoryPage from "@/app/apps/(transactions)/_components/TransactionHistoryPage";
import type { Metadata } from "next";

export const dynamic = "force-static";

const Page = () => {
  return (
    <div>
      <TransactionHistoryPage />
    </div>
  );
};

export default Page;
