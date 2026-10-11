"use client";

import React, { useState, useEffect } from "react";
import { useForm } from "react-hook-form";
import Link from "next/link";
import { useRouter, useSearchParams } from "next/navigation";
import { resetPassword } from "@/lib/api";
import type { Metadata } from "next";

export const metadata: Metadata = {
  title: "Reset Password - Axelit",
  description: "Reset your Axelit account password",
};

type FormData = {
  password: string;
  confirmPassword: string;
};

const ResetPasswordPage = () => {
  const [isLoading, setIsLoading] = useState(false);
  const [success, setSuccess] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [token, setToken] = useState<string | null>(null);

  const {
    register,
    handleSubmit,
    watch,
    formState: { errors },
  } = useForm<FormData>();
  const password = watch("password");

  const router = useRouter();
  const searchParams = useSearchParams();

  useEffect(() => {
    const t = searchParams.get("token");
    if (t) {
      setToken(t);
    }
  }, [searchParams]);

  const onSubmit = async (data: FormData) => {
    if (!token) {
      setError("Missing reset token. Please request a new reset link.");
      return;
    }

    setIsLoading(true);
    setError(null);

    try {
      await resetPassword({
        token,
        password: data.password,
        password_confirmation: data.confirmPassword,
      });
      setSuccess(true);
    } catch (err: any) {
      setError(err?.message || "Failed to reset password. The link may have expired.");
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <div className="auth-page-wrapper">
      <div className="auth-box">
        <div className="auth-header text-center mb-4">
          <h2 className="f-w-700 text-primary-dark">
            {success ? "Password Reset!" : "Reset Password"}
          </h2>
          <p className="text-muted mt-2">
            {success
              ? "Your password has been successfully reset"
              : "Enter your new password below"}
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

            <div className="mb-3">
              <label htmlFor="password" className="form-label f-w-500">
                New Password
              </label>
              <input
                type="password"
                className={`form-control ${errors.password ? "is-invalid" : ""}`}
                id="password"
                placeholder="Enter new password"
                {...register("password", {
                  required: "Password is required",
                  minLength: {
                    value: 8,
                    message: "Password must be at least 8 characters",
                  },
                })}
              />
              {errors.password && (
                <div className="invalid-feedback">{errors.password.message}</div>
              )}
            </div>

            <div className="mb-4">
              <label htmlFor="confirmPassword" className="form-label f-w-500">
                Confirm New Password
              </label>
              <input
                type="password"
                className={`form-control ${errors.confirmPassword ? "is-invalid" : ""}`}
                id="confirmPassword"
                placeholder="Confirm new password"
                {...register("confirmPassword", {
                  required: "Please confirm your password",
                  validate: (value: string) =>
                    value === password || "Passwords do not match",
                })}
              />
              {errors.confirmPassword && (
                <div className="invalid-feedback">{errors.confirmPassword.message}</div>
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
                  Resetting...
                </span>
              ) : (
                "Reset Password"
              )}
            </button>
          </form>
        ) : (
          <div className="text-center">
            <div className="auth-success-icon mb-3">
              <i className="ti ti-check-circle fs-1 text-success"></i>
            </div>
            <h5 className="f-w-600 mb-2">Password Reset Successful</h5>
            <p className="text-muted mb-4">
              Your password has been successfully reset. You can now sign in with your new password.
            </p>
            <Link href="/sign-in" className="btn btn-primary px-4">
              Sign In
            </Link>
          </div>
        )}

        <div className="text-center mt-4">
          <Link href="/sign-in" className="text-muted small">
            Back to Sign In
          </Link>
        </div>
      </div>
    </div>
  );
};

export default ResetPasswordPage;