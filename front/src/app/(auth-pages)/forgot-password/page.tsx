"use client";

import React, { useState } from "react";
import { useForm } from "react-hook-form";
import Link from "next/link";
import type { Metadata } from "next";

export const metadata: Metadata = {
  title: "Forgot Password - Axelit",
  description: "Reset your Axelit account password",
};

const ForgotPasswordPage = () => {
  const [isLoading, setIsLoading] = useState(false);
  const [success, setSuccess] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<{ email: string }>();

  const onSubmit = async (data: { email: string }) => {
    setIsLoading(true);
    setError(null);

    // Simulate API call
    await new Promise((resolve) => setTimeout(resolve, 1000));

    // In a real app, you would call a server action or API here
    setSuccess(true);
    setIsLoading(false);
  };

  return (
    <div className="auth-page-wrapper">
      <div className="auth-box">
        <div className="auth-header text-center mb-4">
          <h2 className="f-w-700 text-primary-dark">Forgot Password?</h2>
          <p className="text-muted mt-2">
            {success
              ? "We've sent a reset link to your email"
              : "Enter your email and we'll send you a reset link"}
          </p>
        </div>

        {!success ? (
          <form onSubmit={handleSubmit(onSubmit)} className="auth-form" noValidate>
            {error && (
              <div className="alert alert-danger alert-dismissible fade show" role="alert">
                {error}
                <button type="button" className="btn-close" onClick={() => setError(null)}></button>
              </div>
            )}

            <div className="mb-4">
              <label htmlFor="email" className="form-label f-w-500">
                Email Address
              </label>
              <input
                type="email"
                className={`form-control ${errors.email ? "is-invalid" : ""}`}
                id="email"
                placeholder="Enter your registered email"
                {...register("email", {
                  required: "Email is required",
                  pattern: {
                    value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i,
                    message: "Invalid email address",
                  },
                })}
              />
              {errors.email && (
                <div className="invalid-feedback">{errors.email.message}</div>
              )}
            </div>

            <button
              type="submit"
              className="btn btn-primary w-100 py-2 f-w-600"
              disabled={isLoading}
            >
              {isLoading ? (
                <span className="d-flex align-items-center justify-content-center gap-2">
                  <span className="spinner-border spinner-border-sm" role="status"></span>
                  Sending...
                </span>
              ) : (
                "Send Reset Link"
              )}
            </button>
          </form>
        ) : (
          <div className="text-center">
            <div className="auth-success-icon mb-3">
              <i className="ti ti-check-circle fs-1 text-success"></i>
            </div>
            <h5 className="f-w-600 mb-2">Check Your Email</h5>
            <p className="text-muted mb-4">
              We've sent a password reset link to your email address.
              Please check your inbox (and spam folder) and follow the instructions.
            </p>
            <Link href="/sign-in" className="btn btn-primary px-4">
              Back to Sign In
            </Link>
          </div>
        )}

        <div className="text-center mt-4">
          <p className="text-muted mb-0">
            Remember your password?{" "}
            <Link href="/sign-in" className="text-primary f-w-600">
              Sign In
            </Link>
          </p>
        </div>
      </div>
    </div>
  );
};

export default ForgotPasswordPage;