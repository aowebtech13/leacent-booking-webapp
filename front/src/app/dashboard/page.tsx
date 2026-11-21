"use client";

import React from "react";
import EcommerceDashboard from "@/Component/Dashboard/EcommerceDashboard";
import { useAuth } from "@/lib/contexts/AuthContext";

const Page = () => {
  const { isAuthenticated } = useAuth();

  if (!isAuthenticated) return null;

  return (
    <div>
      <EcommerceDashboard />
    </div>
  );
};

export default Page;