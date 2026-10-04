import React from "react";
import ProductListPage from "@/app/apps/e-shop/(eshop)/(product-list)/_components/ProductListPage";
import type { Metadata } from "next";

export const dynamic = "force-static";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Products - Axelit",
    description:
      "Browse our collection of products with advanced filtering and search capabilities.",
    keywords: [
      "products",
      "product catalog",
      "product browsing",
      "product search",
      "product filtering",
      "product categories",
      "product sorting",
      "product comparison",
      "product listing",
      "product grid",
      "product view",
      "product features",
      "product availability",
      "product pricing",
      "product categories",
    ],
    openGraph: {
      title: "Products - Axelit",
      description:
        "Browse our collection of products with advanced filtering and search capabilities.",
      url: "https://axelit-next.vercel.app/apps/e-shop/products",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <ProductListPage />
    </div>
  );
};

export default Page;
