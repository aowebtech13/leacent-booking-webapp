import React from "react";
import CheckOutPage from "@/app/apps/e-shop/(eshop)/(checkout)/_components/CheckOutPage";
import type { Metadata } from "next";

export const dynamic = "force-static";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Checkout - Axelit",
    description: "Complete your purchase with our secure checkout process.",
    keywords: [
      "checkout",
      "purchase",
      "payment",
      "secure checkout",
      "payment processing",
      "order confirmation",
      "shipping details",
      "billing information",
      "payment methods",
      "order summary",
      "checkout process",
      "order review",
      "checkout flow",
      "payment gateway",
      "order placement",
    ],
    openGraph: {
      title: "Checkout - Axelit",
      description: "Complete your purchase with our secure checkout process.",
      url: "https://axelit-next.vercel.app/apps/e-shop/checkout",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <CheckOutPage />
    </div>
  );
};

export default Page;
