"use client";

import React, { useState, useEffect, useRef } from "react";
import { useForm } from "react-hook-form";
import Link from "next/link";
import { useRouter } from "next/navigation";
import { useAuth } from "@/lib/contexts/AuthContext";
import { verifyOtp as apiVerifyOtp, AuthResponse } from "@/lib/api";

type FormData = {
  otp0: string;
  otp1: string;
  otp2: string;
  otp3: string;
  otp4: string;
};

const otpFields = ["otp0", "otp1", "otp2", "otp3", "otp4"] as const;

const VerifyOtpForm = ({ email: initialEmail }: { email: string | null }) => {
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [resendTimer, setResendTimer] = useState(60);
  const [canResend, setCanResend] = useState(false);
  const [email] = useState<string | null>(initialEmail);
  const timerRef = useRef<ReturnType<typeof setTimeout> | null>(null);
  const inputsRef = useRef<(HTMLInputElement | null)[]>([]);
  const router = useRouter();
  const { setAuth } = useAuth();

  const {
    register,
    handleSubmit,
    setValue,
    formState: { errors },
  } = useForm<FormData>();

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
    const fieldName = otpFields[index];
    if (fieldName) {
      setValue(fieldName, value, { shouldValidate: true });
    }

    if (value.length === 1 && index < 4) {
      inputsRef.current[index + 1]?.focus();
    }
    if (value.length === 0 && index > 0) {
      inputsRef.current[index - 1]?.focus();
    }
  };

  const handlePaste = (e: React.ClipboardEvent<HTMLInputElement>, startIndex: number) => {
    e.preventDefault();
    const pastedData = e.clipboardData.getData("text").replace(/\D/g, "").slice(0, 5);
    if (pastedData.length === 0) return;

    const digits = pastedData.split("");
    digits.forEach((digit, offset) => {
      const index = startIndex + offset;
      if (index >= otpFields.length) return;
      const fieldName = otpFields[index];
      if (fieldName) {
        setValue(fieldName, digit, { shouldValidate: true });
      }
    });

    const nextIndex = Math.min(startIndex + digits.length, otpFields.length - 1);
    inputsRef.current[nextIndex]?.focus();
  };

  const onSubmit = async (data: FormData) => {
    setIsLoading(true);
    setError(null);

    const code = otpFields.map((field) => data[field as keyof FormData]).join("");

    if (!email) {
      setError("Missing email. Please go back and sign in again.");
      setIsLoading(false);
      return;
    }

    try {
      const res: AuthResponse = await apiVerifyOtp({ email, code });
      setAuth(res);
      router.push("/apps/setting");
    } catch (err: any) {
      setError(err?.message || "Invalid OTP. Please try again.");
      setIsLoading(false);
      otpFields.forEach((field) => {
        setValue(field, "");
      });
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
    <div className="login-card otp-verify-card">
      
      
      <div className="login-main otp-verify-main">
                      <img src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png" alt="Leacent Logo" height="48" />

        
        <div className="theme-form otp-theme-form">

            <h4 className="f-w-700 text-primary-dark">Verify OTP</h4>
            <p className="text-muted mt-3">
              Enter the 5-digit code sent to your email
            </p>
          </div>

          <form onSubmit={handleSubmit(onSubmit)} className="auth-form needs-validation otp-auth-form" noValidate>
            {error && (
              <div className="alert alert-danger alert-dismissible fade show" role="alert">
                {error}
                <button type="button" className="btn-close" onClick={() => setError(null)}></button>
              </div>
            )}

            <div className="form-group mb-5">
              <div className="d-flex justify-content-center gap-3 otp-inputs">
                {otpFields.map((field, index) => (
                  <input
                      key={field}
                      type="text"
                      maxLength={1}
                      inputMode="numeric"
                      className={`form-control text-center otp-input ${errors[field] ? "is-invalid" : ""} otp-input-lg`}
                    {...register(field, {
                      required: "Required",
                      pattern: {
                        value: new RegExp("^\\d$"),
                        message: "Numbers only",
                      },
                    })}
                    autoComplete="one-time-code"
                    onPaste={(e) => handlePaste(e, index)}
                  />
                ))}
              </div>
              {errors.otp0 && (
                <div className="invalid-feedback d-block text-center mb-4">
                  Please enter the complete 5-digit code
                </div>
              )}
            </div>

            <button
              type="submit"
              className="btn btn-primary w-100 py-3 f-w-600 fs-5 otp-verify-btn"
              disabled={isLoading}
            >
              {isLoading ? (
                <span className="d-flex align-items-center justify-content-center gap-2">
                  <span className="spinner-border spinner-border-sm" role="status"></span>
                  Verifying...
                </span>
              ) : (
                "Verify Code"
              )}
            </button>
          </form>

          <div className="text-center mt-5">
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

          <div className="text-center mt-4">
            <Link href="/auth-pages/sign-in" className="text-muted small fw-bold">
              Back to Sign In
            </Link>
          </div>
        </div>
      </div>
  );
};

export default VerifyOtpForm;
