"use client";

import React, { useState, useEffect, useRef } from "react";
import { useForm } from "react-hook-form";
import Link from "next/link";
import { useRouter, useSearchParams } from "next/navigation";
import { useAuth } from "@/lib/contexts/AuthContext";
import { verifyOtp as apiVerifyOtp, AuthResponse } from "@/lib/api";
import type { Metadata } from "next";

export const metadata: Metadata = {
  title: "Verify OTP - Axelit",
  description: "Verify your OTP to complete the process",
};

type FormData = {
  otp0: string;
  otp1: string;
  otp2: string;
  otp3: string;
  otp4: string;
};

const VerifyOtpPage = () => {
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [resendTimer, setResendTimer] = useState(60);
  const [canResend, setCanResend] = useState(false);
  const [email, setEmail] = useState<string | null>(null);
  const timerRef = useRef<NodeJS.Timeout | null>(null);
  const inputsRef = useRef<(HTMLInputElement | null)[]>([]);
  const router = useRouter();
  const searchParams = useSearchParams();
  const { setAuth } = useAuth();

  const {
    register,
    handleSubmit,
    setValue,
    formState: { errors },
  } = useForm<FormData>();

  useEffect(() => {
    const emailParam = searchParams.get("email");
    if (emailParam) {
      setEmail(emailParam);
    }
  }, [searchParams]);

  useEffect(() => {
    timerRef.current = setInterval(() => {
      setResendTimer((prev) => {
        if (prev <= 1) {
          setCanResend(true);
          if (timerRef.current) clearInterval(timerRef.current);
          return 0;
        }
        return prev - 1;
      });
    }, 1000);

    return () => {
      if (timerRef.current) clearInterval(timerRef.current);
    };
  }, []);

  const handleOtpChange = (index: number, value: string) => {
    const fieldName = `otp${index}` as const;
    setValue(fieldName, value, { shouldValidate: true });

    if (value.length === 1 && index < 4) {
      inputsRef.current[index + 1]?.focus();
    }
    if (value.length === 0 && index > 0) {
      inputsRef.current[index - 1]?.focus();
    }
  };

  const handlePaste = (e: React.ClipboardEvent<HTMLInputElement>) => {
    e.preventDefault();
    const pastedData = e.clipboardData.getData("text").slice(0, 5);
    if (/^\d{5}$/.test(pastedData)) {
      pastedData.split("").forEach((digit, index) => {
        setValue(`otp${index}` as const, digit, { shouldValidate: true });
      });
      inputsRef.current[4]?.focus();
    }
  };

  const onSubmit = async (data: FormData) => {
    setIsLoading(true);
    setError(null);

    const code = [data.otp0, data.otp1, data.otp2, data.otp3, data.otp4].join("");

    if (!email) {
      setError("Missing email. Please go back and sign up again.");
      setIsLoading(false);
      return;
    }

    try {
      const res: AuthResponse = await apiVerifyOtp({ email, code });
      setAuth(res);
      router.push("/dashboard/ecommerce");
    } catch (err: any) {
      setError(err?.message || "Invalid OTP. Please try again.");
      setIsLoading(false);
      for (let i = 0; i < 5; i++) {
        setValue(`otp${i}` as const, "");
      }
      inputsRef.current[0]?.focus();
    }
  };

  const handleResend = () => {
    if (!canResend) return;
    setResendTimer(60);
    setCanResend(false);
    timerRef.current = setInterval(() => {
      setResendTimer((prev) => {
        if (prev <= 1) {
          setCanResend(true);
          if (timerRef.current) clearInterval(timerRef.current);
          return 0;
        }
        return prev - 1;
      });
    }, 1000);
  };

  return (
    <div className="auth-page-wrapper">
      <div className="auth-box">
        <div className="auth-header text-center mb-4">
          <h2 className="f-w-700 text-primary-dark">Verify OTP</h2>
          <p className="text-muted mt-2">
            Enter the 5-digit code sent to your email
          </p>
        </div>

        <form onSubmit={handleSubmit(onSubmit)} className="auth-form" noValidate>
          {error && (
            <div className="alert alert-danger alert-dismissible fade show" role="alert">
              {error}
              <button type="button" className="btn-close" onClick={() => setError(null)}></button>
            </div>
          )}

          <div className="d-flex justify-content-center gap-2 mb-4 otp-inputs">
            {[0, 1, 2, 3, 4].map((index) => (
              <input
                key={index}
                ref={(el) => (inputsRef.current[index] = el)}
                type="text"
                maxLength={1}
                inputMode="numeric"
                pattern="[0-9]*"
                className={`form-control text-center otp-input ${
                  errors[`otp${index}` as const] ? "is-invalid" : ""
                }`}
                onChange={(e) => handleOtpChange(index, e.target.value)}
                onPaste={handlePaste}
                onKeyDown={(e) => {
                  if (e.key === "Backspace" && !e.currentTarget.value && index > 0) {
                    inputsRef.current[index - 1]?.focus();
                  }
                }}
                {...register(`otp${index}` as const, {
                  required: "Required",
                  pattern: {
                    value: /^\d$/,
                    message: "Numbers only",
                  },
                })}
                autoComplete="one-time-code"
              />
            ))}
          </div>

          {errors.otp0 && (
            <div className="invalid-feedback d-block text-center mb-3">
              Please enter the complete 5-digit code
            </div>
          )}

          <button
            type="submit"
            className="btn btn-primary w-100 py-2 f-w-600"
            disabled={isLoading}
          >
            {isLoading ? (
              <span className="d-flex align-items-center justify-content-center gap-2">
                <span className="spinner-border spinner-border-sm" role="status"></span>
                Verifying...
              </span>
            ) : (
              "Verify"
            )}
          </button>
        </form>

        <div className="text-center mt-4">
          <p className="text-muted mb-0">
            Didn't receive the code?{" "}
            <button
              type="button"
              className={`text-primary f-w-600 ${!canResend ? "text-muted" : ""}`}
              onClick={handleResend}
              disabled={!canResend}
            >
              {canResend ? "Resend Code" : `Resend in ${resendTimer}s`}
            </button>
          </p>
        </div>

        <div className="text-center mt-3">
          <Link href="/sign-in" className="text-muted small">
            Back to Sign In
          </Link>
        </div>
      </div>
    </div>
  );
};

export default VerifyOtpPage;