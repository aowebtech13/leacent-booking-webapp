"use server";

import { redirect } from "next/navigation";
import {
  login,
  register,
  verifyOtp as apiVerifyOtp,
  forgotPassword,
  resetPassword,
  resendOtp,
} from "@/lib/api/auth";

/**
 * Error shape returned by the API layer when a request fails.
 * Server actions throw this so the UI can surface the message.
 */
export class ActionError extends Error {
  status: number | undefined;
  data: any;
  constructor(message: string, status?: number, data?: any) {
    super(message);
    this.name = "ActionError";
    this.status = status;
    this.data = data;
  }
}

/**
 * Wrap an unknown error thrown by the API layer into an ActionError so the
 * UI layer can reliably read `error.message`.
 */
export function toActionError(error: any): ActionError {
  if (error instanceof ActionError) return error;
  const message =
    error?.message ||
    (error?.response?.data?.message) ||
    (error?.data?.message) ||
    "Something went wrong";
  const status = error?.status || error?.response?.status;
  const data = error?.data || error?.response?.data;
  return new ActionError(message, status, data);
}

export async function unlockScreen(formData: FormData): Promise<void> {
  const password = formData.get("password");
  const remember = formData.get("rememberMe");

  redirect("/");
}

export async function unlockScreenImg(formData: FormData): Promise<void> {
  const password = formData.get("password") as string;

  redirect("/");
}

export async function createPassword(formData: FormData): Promise<void> {
  const current = formData.get("currentPassword")?.toString();
  const newPass = formData.get("newPassword")?.toString();
  const confirm = formData.get("confirmPassword")?.toString();

  await new Promise((res) => setTimeout(res, 500));

  redirect("/auth-pages/sign-in");
}

export async function resetPasswordAction(formData: FormData): Promise<void> {
  const token = formData.get("token") as string;
  const password = formData.get("password") as string;
  const password_confirmation = formData.get("password_confirmation") as string;

  try {
    await resetPassword({ token, password, password_confirmation });
    redirect("/auth-pages/sign-in");
  } catch (error: any) {
    throw toActionError(error);
  }
}

/**
 * Log a user in.
 *
 * The backend enforces email verification: if the account is not yet verified
 * the login endpoint responds with a 422 and a message telling the user to
 * verify. In that case we redirect to the two-step-verification page so the
 * user can complete the OTP flow (the backend has already emailed a fresh
 * code for the unverified account).
 */
export async function loginUser(formData: FormData): Promise<void> {
  const email = formData.get("username") as string;
  const password = formData.get("password") as string;

  try {
    await login({ email, password });
    redirect("/");
  } catch (error: any) {
    const actionError = toActionError(error);
    // Backend returns 422 for unverified-email logins.
    if (actionError.status === 422) {
      redirect(
        `/auth-pages/two-step-verification?email=${encodeURIComponent(email)}`
      );
    }
    throw actionError;
  }
}

export async function loginUserImg(formData: FormData): Promise<void> {
  const email = formData.get("username") as string;
  const password = formData.get("password") as string;

  try {
    await login({ email, password });
    redirect("/");
  } catch (error: any) {
    const actionError = toActionError(error);
    if (actionError.status === 422) {
      redirect(
        `/auth-pages/two-step-verification?email=${encodeURIComponent(email)}`
      );
    }
    throw actionError;
  }
}

export async function registerUser(formData: FormData): Promise<void> {
  const name = formData.get("username") as string;
  const email = formData.get("email") as string;
  const password = formData.get("password") as string;
  const password_confirmation = formData.get("confirmPassword") as string;
  const phone = formData.get("phone") as string | null;

  const payload: {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
    phone?: string;
  } = {
    name,
    email,
    password,
    password_confirmation,
  };
  if (phone) payload.phone = phone;

  try {
    await register(payload);
    redirect(`/auth-pages/two-step-verification?email=${encodeURIComponent(email)}`);
  } catch (error: any) {
    throw toActionError(error);
  }
}

export async function forgotPasswordAction(formData: FormData): Promise<void> {
  const email = formData.get("email") as string;

  try {
    await forgotPassword({ email });
    redirect("/auth-pages/sign-in?reset=sent");
  } catch (error: any) {
    throw toActionError(error);
  }
}

export async function verifyOtp(formData: FormData): Promise<void> {
  const email = formData.get("email") as string;
  const otpDigits = [
    formData.get("otp0"),
    formData.get("otp1"),
    formData.get("otp2"),
    formData.get("otp3"),
  ].join("");

  try {
    await apiVerifyOtp({ email, code: otpDigits });
    redirect("/");
  } catch (error: any) {
    throw toActionError(error);
  }
}

export async function resendOtpAction(
  formData: FormData
): Promise<{ success: boolean; message: string }> {
  const email = formData.get("email") as string;

  try {
    await resendOtp({ email });
    return { success: true, message: "Verification code resent." };
  } catch (error: any) {
    throw toActionError(error);
  }
}
