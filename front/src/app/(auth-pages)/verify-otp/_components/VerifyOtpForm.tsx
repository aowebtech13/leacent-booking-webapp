"use client";

import React, { useState, useEffect, useRef } from "react";
import { useForm } from "react-hook-form";
import Link from "next/link";
import Image from "next/image";
import { useRouter } from "next/navigation";
import { useAuth } from "@/lib/contexts/AuthContext";
import { verifyOtp as apiVerifyOtp, resendOtp as apiResendOtp, AuthResponse } from "@/lib/api";

type FormData = {
  code: string;
};

const VerifyOtpForm = ({ email: initialEmail }: { email: string | null }) => {
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [resendMessage, setResendMessage] = useState<string | null>(null);
  const [resendTimer, setResendTimer] = useState(60);
  const [canResend, setCanResend] = useState(false);
  const [email] = useState<string | null>(initialEmail);
  const timerRef = useRef<ReturnType<typeof setTimeout> | null>(null);
  const verifyingRef = useRef<string | null>(null);
  const router = useRouter();
  const { setAuth } = useAuth();

  const {
    register,
    handleSubmit,
    setValue,
    watch,
  } = useForm<FormData>();

  const code = watch("code");

  useEffect(() => {
    if (code && code.length === 5 && !isLoading && verifyingRef.current !== code) {
      verifyingRef.current = code;
      onSubmit({ code });
    }
  }, [code, isLoading]);

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
      const res: AuthResponse = await apiVerifyOtp({ email, code });
      setAuth(res);
      router.push("/apps/setting");
    } catch (err: any) {
      verifyingRef.current = null;
      setError(err?.message || "Invalid OTP. Please try again.");
      setIsLoading(false);
      setValue("code", "");
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
      setResendMessage("Code has been resent");
      setTimeout(() => setResendMessage(null), 4000);
    } catch (err: any) {
      setResendTimer(60);
      setCanResend(false);
      setError(
        err?.message ||
          "Email not sent. Please contact support."
      );
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
             <div className="otp-input-wrapper">
               <input
                 type="text"
                 maxLength={5}
                 inputMode="numeric"
                 autoComplete="one-time-code"
                 autoFocus
                 className="form-control text-center otp-input-lg otp-input-with-divider"
                 {...register("code", { required: "Required" })}
               />
               <div className="otp-divider">
                 <span>-</span>
                 <span>-</span>
                 <span>-</span>
                 <span>-</span>
               </div>
             </div>
           </div>
         </form>

        <div className="text-center mt-5">
          {resendMessage && (
            <div
              className="alert alert-success alert-dismissible fade show"
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
