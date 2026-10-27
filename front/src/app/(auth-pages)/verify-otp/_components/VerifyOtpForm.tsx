"use client";

import React, { useState, useEffect, useRef } from "react";
import { useForm } from "react-hook-form";
import Link from "next/link";
import Image from "next/image";
import { useRouter } from "next/navigation";
import { useAuth } from "@/lib/contexts/AuthContext";
import { verifyOtp as apiVerifyOtp, AuthResponse } from "@/lib/api";

type FormData = {
  code: string;
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
    getValues,
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
    const field = otpFields[index];
    if (!field) return;
    setValue(field, value, { shouldValidate: true });

    if (value.length === 1 && index < 4) {
      inputsRef.current[index + 1]?.focus();
    }
    if (value.length === 0 && index > 0) {
      inputsRef.current[index - 1]?.focus();
    }
  };

  const handleAllCodesChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const digits = e.target.value.replace(/\D/g, "").slice(0, 5);
    otpFields.forEach((field, i) => {
      setValue(field, digits[i] || "", { shouldValidate: true });
    });
    e.target.value = digits;
  };

  const handleKeyDown = (
    e: React.KeyboardEvent<HTMLInputElement>,
    index: number
  ) => {
    if (e.key === "ArrowLeft" && index > 0) {
      e.preventDefault();
      inputsRef.current[index - 1]?.focus();
    }
    if (e.key === "ArrowRight" && index < 4) {
      e.preventDefault();
      inputsRef.current[index + 1]?.focus();
    }
    if (
      (e.key === "Backspace" || e.key === "Delete") &&
      !(e.target as HTMLInputElement).value
    ) {
      if (e.key === "Backspace" && index > 0) {
        e.preventDefault();
        inputsRef.current[index - 1]?.focus();
      }
      if (e.key === "Delete" && index < 4) {
        e.preventDefault();
        inputsRef.current[index + 1]?.focus();
      }
    }
    if (e.key === "Backspace" && (e.target as HTMLInputElement).value) {
      (e.target as HTMLInputElement).value = "";
      const field = otpFields[index];
      if (field) {
        setValue(field, "", { shouldValidate: true });
      }
      if (index > 0) {
        inputsRef.current[index - 1]?.focus();
      }
    }
    if (e.key === "Delete" && (e.target as HTMLInputElement).value) {
      (e.target as HTMLInputElement).value = "";
      const field = otpFields[index];
      if (field) {
        setValue(field, "", { shouldValidate: true });
      }
      if (index < 4) {
        inputsRef.current[index + 1]?.focus();
      }
    }
  };

  const handleFocus = (index: number) => {
    const input = inputsRef.current[index];
    input?.select();
  };

  const handlePaste = (
    e: React.ClipboardEvent<HTMLInputElement>,
    startIndex: number
  ) => {
    e.preventDefault();
    const pastedData = e.clipboardData
      .getData("text")
      .replace(/\D/g, "")
      .slice(0, 5);
    if (pastedData.length === 0) return;

    const digits = pastedData.split("");
    // Start from the first empty field so pasting always fills from the beginning
    const firstEmpty = otpFields.findIndex((f) => !errors[f] && !getValue(f));
    const start = firstEmpty >= 0 ? firstEmpty : startIndex;

    digits.forEach((digit, offset) => {
      const index = start + offset;
      if (index >= otpFields.length) return;
      const field = otpFields[index];
      if (field) {
        setValue(field, digit, { shouldValidate: true });
      }
    });

    const nextIndex = Math.min(start + digits.length, otpFields.length - 1);
    inputsRef.current[nextIndex]?.focus();
  };

  const getValue = (field: string) => {
    return (getValues() as Record<string, string>)[field] || "";
  };

  const onSubmit = async (data: FormData) => {
    setIsLoading(true);
    setError(null);

    const code = data.code;

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
      setValue("code", "");
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
        <Image
          src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1793002438/WhatsApp_Image_0008-10-26_at_01.07.28-removebg-preview-removebg-preview_giyzud.png"
          alt="Leacent Logo"
          className="otp-logo"
          width={87}
          height={48}
          sizes="87px"
          priority
        />

        <div className="theme-form otp-theme-form">
          <h4 className="f-w-700 text-primary-dark">Verify OTP</h4>
          <p className="text-muted mt-3 fw-bold">
            Enter the 5-digit code sent to your email
          </p>
        </div>

        <form
          onSubmit={handleSubmit(onSubmit)}
          className="auth-form needs-validation otp-auth-form"
          noValidate
        >
          {error && (
            <div
              className="alert alert-danger alert-dismissible fade show"
              role="alert"
            >
              {error}
              <button
                type="button"
                className="btn-close"
                onClick={() => setError(null)}
              ></button>
            </div>
          )}

           <div className="form-group mb-5">
             <input
               type="text"
               maxLength={5}
               inputMode="numeric"
               autoComplete="one-time-code"
               autoFocus
               className="form-control text-center otp-input-lg"
               {...register("code", { required: "Required" })}
             />
           </div>

          <button
            type="submit"
            className="btn btn-primary w-100 py-3 f-w-600 fs-5 otp-verify-btn"
            disabled={isLoading}
          >
            {isLoading ? (
              <span className="d-flex align-items-center justify-content-center gap-2">
                <span
                  className="spinner-border spinner-border-sm"
                  role="status"
                ></span>
                Verifying...
              </span>
            ) : (
              "Verify Code"
            )}
          </button>
        </form>

        <div className="text-center mt-5">
          <p className="text-muted mb-0">
            Didn&apos;t receive the code?{" "}
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
