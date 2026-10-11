"use client";

import React, { useState } from "react";
import { useForm } from "react-hook-form";
import Link from "next/link";
import { loginUser } from "@/lib/auth/action";
import type { Metadata } from "next";

export const metadata: Metadata = {
  title: "Sign In - Axelit",
  description: "Sign in to your Axelit account",
};

const SignInPage = () => {
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<{ username: string; password: string }>();

  const onSubmit = async (data: { username: string; password: string }) => {
    setIsLoading(true);
    setError(null);

    const formData = new FormData();
    formData.append("username", data.username);
    formData.append("password", data.password);

    try {
      await loginUser(formData);
    } catch (err) {
      setError("Invalid credentials. Please try again.");
      setIsLoading(false);
    }
  };

  return (
    <div className="auth-page-wrapper">
      <div className="auth-box">
        <div className="auth-header text-center mb-4">
          <h2 className="f-w-700 text-primary-dark">Welcome Back</h2>
          <p className="text-muted mt-2">Sign in to your account</p>
        </div>

        <form onSubmit={handleSubmit(onSubmit)} className="auth-form" noValidate>
          {error && (
            <div className="alert alert-danger alert-dismissible fade show" role="alert">
              {error}
              <button type="button" className="btn-close" onClick={() => setError(null)}></button>
            </div>
          )}

          <div className="mb-3">
            <label htmlFor="username" className="form-label f-w-500">
              Username or Email
            </label>
            <input
              type="text"
              className={`form-control ${errors.username ? "is-invalid" : ""}`}
              id="username"
              placeholder="Enter your username or email"
              {...register("username", {
                required: "Username or email is required",
              })}
            />
            {errors.username && (
              <div className="invalid-feedback">{errors.username.message}</div>
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
              placeholder="Enter your password"
              {...register("password", {
                required: "Password is required",
                minLength: {
                  value: 6,
                  message: "Password must be at least 6 characters",
                },
              })}
            />
            {errors.password && (
              <div className="invalid-feedback">{errors.password.message}</div>
            )}
          </div>

          <div className="d-flex justify-content-between align-items-center mb-4">
            <div className="form-check">
              <input
                type="checkbox"
                className="form-check-input"
                id="rememberMe"
                name="rememberMe"
              />
              <label className="form-check-label text-muted" htmlFor="rememberMe">
                Remember me
              </label>
            </div>
            <Link href="/forgot-password" className="text-primary f-w-500">
              Forgot Password?
            </Link>
          </div>

          <button
            type="submit"
            className="btn btn-primary w-100 py-2 f-w-600"
            disabled={isLoading}
          >
            {isLoading ? (
              <span className="d-flex align-items-center justify-content-center gap-2">
                <span className="spinner-border spinner-border-sm" role="status"></span>
                Signing in...
              </span>
            ) : (
              "Sign In"
            )}
          </button>
        </form>

        <div className="text-center mt-4">
          <p className="text-muted mb-0">
            Don't have an account?{" "}
            <Link href="/sign-up" className="text-primary f-w-600">
              Sign Up
            </Link>
          </p>
        </div>

        <div className="divider my-4">
          <span>Or continue with</span>
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

export default SignInPage;