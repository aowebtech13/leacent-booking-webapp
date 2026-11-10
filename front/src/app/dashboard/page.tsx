"use client";

import React, { useEffect } from "react";
import { useRouter } from "next/navigation";
import EcommerceDashboard from "@/Component/Dashboard/EcommerceDashboard";
import { useAuth } from "@/lib/contexts/AuthContext";

const Page = () => {
  const { isAuthenticated, isLoading, user } = useAuth();
  const router = useRouter();

  useEffect(() => {
    if (!isLoading && !isAuthenticated) {
      router.replace("/auth-pages/sign-in?redirect=/dashboard");
    }
  }, [isAuthenticated, isLoading, router]);

  if (isLoading) {
    return (
      <div className="d-flex justify-content-center align-items-center" style={{ minHeight: "100vh" }}>
        <div className="spinner-border text-primary" role="status">
          <span className="visually-hidden">Loading...</span>
        </div>
      </div>
    );
  }

  if (!isAuthenticated || !user) {
    return null;
  }

  return (
    <div>
      <EcommerceDashboard />
    </div>
  );
};

export default Page;
