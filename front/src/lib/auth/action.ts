"use server";

import { redirect } from "next/navigation";
import { cookies } from "next/headers";
import {
  login,
  register,
  verifyOtp as apiVerifyOtp,
  forgotPassword,
  resetPassword,
  resendOtp,
  type AuthResponse,
} from "@/lib/api/auth";
import { ActionError, toActionError } from "./action-error";
import { POST_LOGIN_PATH } from "./constants";

export { ActionError };

const PENDING_EMAIL_COOKIE = "pending_email";
const PENDING_EMAIL_MAX_AGE = 300;

async function setPendingEmail(email: string) {
  const cookieStore = await cookies();
  cookieStore.set(PENDING_EMAIL_COOKIE, email, {
    httpOnly: true,
    secure: process.env.NODE_ENV === "production",
    maxAge: PENDING_EMAIL_MAX_AGE,
    path: "/",
  });
}

async function clearPendingEmail() {
  const cookieStore = await cookies();
  cookieStore.delete(PENDING_EMAIL_COOKIE);
}

export async function unlockScreen(_formData: FormData): Promise<void> {
  redirect(POST_LOGIN_PATH);
}

export async function unlockScreenImg(_formData: FormData): Promise<void> {
  redirect(POST_LOGIN_PATH);
}

export async function createPassword(_formData: FormData): Promise<void> {
  await new Promise((res) => setTimeout(res, 500));
  redirect("/auth-pages/sign-in");
}

export async function resetPasswordAction(formData: FormData): Promise<void> {
  const token = formData.get("token") as string;
  const password = formData.get("password") as string;
  const password_confirmation = formData.get("password_confirmation") as string;

  try {
    await resetPassword({ token, password, password_confirmation });
  } catch (error: any) {
    throw toActionError(error);
  }

  redirect("/auth-pages/sign-in");
}

export async function loginUser(
  formData: FormData
): Promise<AuthResponse | { error: string | null }> {
  const email = formData.get("email") as string;
  const password = formData.get("password") as string;

  try {
    return await login({ email, password });
  } catch (error: any) {
    const actionError = toActionError(error);

    // 422 = unverified email (redirects safely)
    if (actionError.status === 422) {
      await setPendingEmail(email);
      redirect("/verify-otp");
    }

    return { error: actionError.message };
  }
}

export async function loginUserImg(
  formData: FormData
): Promise<AuthResponse | { error: string | null }> {
  const email = formData.get("email") as string;
  const password = formData.get("password") as string;

  try {
    return await login({ email, password });
  } catch (error: any) {
    const actionError = toActionError(error);

    if (actionError.status === 422) {
      await setPendingEmail(email);
      redirect("/verify-otp");
    }

    return { error: actionError.message };
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
  } catch (error: any) {
    throw toActionError(error);
  }

  await setPendingEmail(email);
  redirect("/verify-otp");
}

export async function forgotPasswordAction(formData: FormData): Promise<void> {
  const email = formData.get("email") as string;

  try {
    await forgotPassword({ email });
  } catch (error: any) {
    throw toActionError(error);
  }

  await setPendingEmail(email);
  redirect("/verify-otp?purpose=password-reset");
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
  } catch (error: any) {
    throw toActionError(error);
  }

  await clearPendingEmail();
  redirect("/apps/setting");
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
