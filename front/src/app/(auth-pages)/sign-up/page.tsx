"use client";

import React, { useState } from "react";
import { useForm } from "react-hook-form";
import Link from "next/link";
import type { Metadata } from "next";

export const metadata: Metadata = {
  title: "Sign Up - Axelit",
  description: "Create your Axelit account",
};

const SignUpPage = () => {
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const {
    register,
    handleSubmit,
    watch,
    formState: { errors },
  } = useForm<{
    fullName: string;
    email: string;
    password: string;
    confirmPassword: string;
    terms: boolean;
  }>();

  const password = watch("password");

  const onSubmit = async (data: {
    fullName: string;
    email: string;
    password: string;
    confirmPassword: string;
    terms: boolean;
  }) => {
    setIsLoading(true);
    setError(null);

    // Simulate API call
    await new Promise((resolve) => setTimeout(resolve, 1000));

    // In a real app, you would call a server action or API here
    // For now, redirect to verify-otp
    window.location.href = "/verify-otp";
  };

  return (
    <div className="auth-page-wrapper">
      <div className="auth-box">
        <div className="auth-header text-center mb-4">
          <h2 className="f-w-700 text-primary-dark">Create Account</h2>
          <p className="text-muted mt-2">Join Axelit today</p>
        </div>

        <form onSubmit={handleSubmit(onSubmit)} className="auth-form" noValidate>
          {error && (
            <div className="alert alert-danger alert-dismissible fade show" role="alert">
              {error}
              <button type="button" className="btn-close" onClick={() => setError(null)}></button>
            </div>
          )}

          <div className="mb-3">
            <label htmlFor="fullName" className="form-label f-w-500">
              Full Name
            </label>
            <input
              type="text"
              className={`form-control ${errors.fullName ? "is-invalid" : ""}`}
              id="fullName"
              placeholder="Enter your full name"
              {...register("fullName", {
                required: "Full name is required",
                minLength: {
                  value: 2,
                  message: "Name must be at least 2 characters",
                },
              })}
            />
            {errors.fullName && (
              <div className="invalid-feedback">{errors.fullName.message}</div>
            )}
          </div>

          <div className="mb-3">
            <label htmlFor="email" className="form-label f-w-500">
              Email Address
            </label>
            <input
              type="email"
              className={`form-control ${errors.email ? "is-invalid" : ""}`}
              id="email"
              placeholder="Enter your email"
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

          <div className="mb-3">
            <label htmlFor="password" className="form-label f-w-500">
              Password
            </label>
            <input
              type="password"
              className={`form-control ${errors.password ? "is-invalid" : ""}`}
              id="password"
              placeholder="Create a password"
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

          <div className="mb-3">
            <label htmlFor="confirmPassword" className="form-label f-w-500">
              Confirm Password
            </label>
            <input
              type="password"
              className={`form-control ${errors.confirmPassword ? "is-invalid" : ""}`}
              id="confirmPassword"
              placeholder="Confirm your password"
              {...register("confirmPassword", {
                required: "Please confirm your password",
                validate: (value) => value === password || "Passwords do not match",
              })}
            />
            {errors.confirmPassword && (
              <div className="invalid-feedback">{errors.confirmPassword.message}</div>
            )}
          </div>

          <div className="mb-4">
            <div className="form-check">
              <input
                type="checkbox"
                className={`form-check-input ${errors.terms ? "is-invalid" : ""}`}
                id="terms"
                {...register("terms", {
                  required: "You must accept the terms and conditions",
                })}
              />
              <label className="form-check-label text-muted" htmlFor="terms">
                I agree to the{" "}
                <Link href="/other-pages/terms-condition" className="text-primary">
                  Terms & Conditions
                </Link>{" "}
                and{" "}
                <Link href="/other-pages/privacy-policy" className="text-primary">
                  Privacy Policy
                </Link>
              </label>
            </div>
            {errors.terms && (
              <div className="invalid-feedback d-block">{errors.terms.message}</div>
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
                Creating Account...
              </span>
            ) : (
              "Sign Up"
            )}
          </button>
        </form>

        <div className="text-center mt-4">
          <p className="text-muted mb-0">
            Already have an account?{" "}
            <Link href="/sign-in" className="text-primary f-w-600">
              Sign In
            </Link>
          </p>
        </div>

        <div className="divider my-4">
          <span>Or sign up with</span>
        </div>

        <div className="d-grid gap-2">
          <button type="button" className="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2">
            <img src="/images/setting-app/google.png" alt="Google" className="auth-social-icon" />
            Continue with Google
          </button>
          <button type="button" className="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2">
            <img src="/images/setting-app/facebook.png" alt="Facebook" className="auth-social-icon" />
            Continue with Facebook
          </button>
        </div>
      </div>
    </div>
  );
};

export default SignUpPage;