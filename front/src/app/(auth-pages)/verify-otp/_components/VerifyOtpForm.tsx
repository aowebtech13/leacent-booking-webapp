"use client";

import React, { useState, useEffect, useRef, useCallback } from "react";
import { useForm } from "react-hook-form";
import Link from "next/link";
import Image from "next/image";
import { useRouter } from "next/navigation";
import { useAuth } from "@/lib/contexts/AuthContext";
import {
  verifyOtp as apiVerifyOtp,
  resendOtp as apiResendOtp,
  AuthResponse,
} from "@/lib/api";
import { POST_LOGIN_PATH } from "@/lib/auth/constants";
import toast from "@/Component/Services/toast";

type FormData = {
  code: string;
};

const VerifyOtpForm = ({
  email: initialEmail,
  purpose,
}: {
  email: string | null;
  purpose?: string | null;
}) => {
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [resendMessage, setResendMessage] = useState<string | null>(null);
  const [resendTimer, setResendTimer] = useState(60);
  const [canResend, setCanResend] = useState(false);
  const [email] = useState<string | null>(initialEmail);
  const [otpDigits, setOtpDigits] = useState<string[]>(["", "", "", "", ""]);
  const timerRef = useRef<ReturnType<typeof setTimeout> | null>(null);
  const verifyingRef = useRef<string | null>(null);
  const inputRefs = useRef<(HTMLInputElement | null)[]>([
    null,
    null,
    null,
    null,
    null,
  ]);
  const router = useRouter();
  const { setAuth } = useAuth();

  const { register, handleSubmit, setValue } = useForm<FormData>();

  const handleOtpChange = useCallback(
    (index: number, value: string) => {
      if (!/^\d*$/.test(value)) return;
      if (value.length > 1) return;

      const newDigits = [...otpDigits];
      newDigits[index] = value;
      setOtpDigits(newDigits);

      const fullCode = newDigits.join("");
      setValue("code", fullCode, { shouldValidate: true });

      if (value && index < 4) {
        inputRefs.current[index + 1]?.focus();
      }

      if (
        fullCode.length === 5 &&
        !isLoading &&
        verifyingRef.current !== fullCode
      ) {
        verifyingRef.current = fullCode;
        onSubmit({ code: fullCode });
      }
    },
    [otpDigits, setValue, isLoading]
  );

  const handleKeyDown = useCallback(
    (index: number, e: React.KeyboardEvent) => {
      if (e.key === "Backspace" && !otpDigits[index] && index > 0) {
        inputRefs.current[index - 1]?.focus();
      }
      if (e.key === "ArrowLeft" && index > 0) {
        inputRefs.current[index - 1]?.focus();
      }
      if (e.key === "ArrowRight" && index < 4) {
        inputRefs.current[index + 1]?.focus();
      }
    },
    [otpDigits]
  );

  const handlePaste = useCallback(
    (e: React.ClipboardEvent) => {
      e.preventDefault();
      const pasted = e.clipboardData
        .getData("text")
        .replace(/\D/g, "")
        .slice(0, 5);
      const digits = pasted.split("");
      digits.forEach((digit, i) => {
        if (i < 5) {
          const newDigits = [...otpDigits];
          newDigits[i] = digit;
          setOtpDigits(newDigits);
        }
      });
      const fullCode = digits.join("");
      setValue("code", fullCode, { shouldValidate: true });
      if (fullCode.length === 5) {
        inputRefs.current[4]?.focus();
        if (!isLoading && verifyingRef.current !== fullCode) {
          verifyingRef.current = fullCode;
          onSubmit({ code: fullCode });
        }
      }
    },
    [otpDigits, setValue, isLoading]
  );

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
      const payload: {
        email: string;
        code: string;
        purpose?: string | null;
      } = {
        email,
        code,
        purpose: purpose ?? null,
      };
      const res: AuthResponse = await apiVerifyOtp(payload);
      setAuth(res);
      if (purpose === "password-reset") {
        toast.success("Code verified. Set your new password.");
        await new Promise((r) => setTimeout(r, 500));
        router.push(`/auth-pages/reset-password?token=${res.access_token}`);
        return;
      }
      toast.success(
        "Account verified. Welcome bonus points have been added to your wallet."
      );
      await new Promise((r) => setTimeout(r, 500));
      router.replace(POST_LOGIN_PATH);
    } catch (err: any) {
      verifyingRef.current = null;
      setError(err?.message || "Invalid OTP. Please try again.");
      setIsLoading(false);
      setValue("code", "");
      setOtpDigits(["", "", "", "", ""]);
      inputRefs.current[0]?.focus();
    }
  };

  const handleResend = async () => {
    if (!canResend) return;
    if (!email) {
      setError("Missing email. Please go back and sign in again.");
      return;
    }
    setResendMessage(null);
    setError(null);
    setResendTimer(60);
    setCanResend(false);
    try {
      await apiResendOtp({ email });
      setResendMessage("A new verification code has been sent to your email.");
      toast.info("Verification code resent.");
      setTimeout(() => setResendMessage(null), 4000);
    } catch (err: any) {
      setResendTimer(60);
      setCanResend(false);
      setError(err?.message || "Email not sent. Please contact support.");
    }
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
            <div className="otp-inputs-container d-flex justify-content-center gap-3">
              {Array.from({ length: 5 }).map((_, i) => (
                <input
                  key={i}
                  ref={(el) => { inputRefs.current[i] = el; }}
                  type="text"
                  inputMode="numeric"
                  maxLength={1}
                  autoComplete="one-time-code"
                  autoFocus={i === 0}
                  className={`form-control otp-digit-input text-center ${otpDigits[i] ? "filled" : ""}`}
                  value={otpDigits[i]}
                  onChange={(e) => handleOtpChange(i, e.target.value)}
                  onKeyDown={(e) => handleKeyDown(i, e)}
                  onPaste={handlePaste}
                  disabled={isLoading}
                  aria-label={`OTP digit ${i + 1}`}
                />
              ))}
              <input
                type="hidden"
                {...register("code", { required: "Required" })}
              />
            </div>
          </div>
        </form>

        <div className="text-center mt-5">
          {resendMessage && (
            <div
              className="alert alert-success alert-dismissible fade show text-dark"
              role="alert"
            >
              {resendMessage}
              <button
                type="button"
                className="btn-close"
                onClick={() => setResendMessage(null)}
              ></button>
            </div>
          )}
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
