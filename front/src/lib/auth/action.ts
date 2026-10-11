"use server";

import { redirect } from "next/navigation";
import { login, register, verifyOtp as apiVerifyOtp, forgotPassword, resetPassword } from "@/lib/api/auth";

export async function unlockScreen(formData: FormData) {
  const password = formData.get("password");
  const remember = formData.get("rememberMe");

  redirect("/");

  return {
    password,
    remember,
  };
}

export async function unlockScreenImg(formData: FormData) {
  const password = formData.get("password") as string;

  redirect("/");
  return {
    password,
  };
}

export async function createPassword(formData: FormData) {
  const current = formData.get("currentPassword")?.toString();
  const newPass = formData.get("newPassword")?.toString();
  const confirm = formData.get("confirmPassword")?.toString();

  await new Promise((res) => setTimeout(res, 500));

  redirect("/auth-pages/sign-in");

  return {
    current,
    newPass,
    confirm,
  };
}

export async function resetPasswordAction(formData: FormData) {
  const token = formData.get("token") as string;
  const password = formData.get("password") as string;
  const password_confirmation = formData.get("password_confirmation") as string;

  try {
    await resetPassword({ token, password, password_confirmation });
    redirect("/auth-pages/sign-in");
  } catch (error: any) {
    throw new Error(error.message || "Failed to reset password");
  }

  return {
    token,
    password,
    password_confirmation,
  };
}

export async function loginUser(formData: FormData) {
  const email = formData.get("username") as string;
  const password = formData.get("password") as string;

  try {
    await login({ email, password });
    redirect("/");
  } catch (error: any) {
    throw new Error(error.message || "Invalid credentials");
  }

  return {
    password,
    email,
  };
}

export async function loginUserImg(formData: FormData) {
  const email = formData.get("username") as string;
  const password = formData.get("password") as string;

  try {
    await login({ email, password });
    redirect("/");
  } catch (error: any) {
    throw new Error(error.message || "Invalid credentials");
  }

  return {
    password,
    email,
  };
}

export async function registerUser(formData: FormData) {
  const name = formData.get("username") as string;
  const email = formData.get("email") as string;
  const password = formData.get("password") as string;
  const password_confirmation = formData.get("confirmPassword") as string;
  const phone = formData.get("phone") as string | null;

  const payload: { name: string; email: string; password: string; password_confirmation: string; phone?: string } = {
    name,
    email,
    password,
    password_confirmation,
  };
  if (phone) payload.phone = phone;

  try {
    await register(payload);
    redirect("/auth-pages/two-step-verification");
  } catch (error: any) {
    throw new Error(error.message || "Registration failed");
  }

  return {
    name,
    email,
    password,
    password_confirmation,
    phone,
  };
}

export async function forgotPasswordAction(formData: FormData) {
  const email = formData.get("email") as string;

  try {
    await forgotPassword({ email });
    redirect("/auth-pages/password-reset");
  } catch (error: any) {
    throw new Error(error.message || "Failed to send reset email");
  }

  return {
    email,
  };
}

export async function verifyOtp(formData: FormData) {
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
    throw new Error(error.message || "Invalid verification code");
  }

  return {
    email,
    otpDigits,
  };
}

export async function resendOtpAction(formData: FormData) {
  const email = formData.get("email") as string;

  try {
    const { resendOtp } = await import("@/lib/api/auth");
    await resendOtp({ email });
    return { success: true, message: "Verification code resent." };
  } catch (error: any) {
    throw new Error(error.message || "Failed to resend code");
  }
}
