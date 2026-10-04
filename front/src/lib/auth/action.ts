"use server";

import { redirect } from "next/navigation";

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

export async function resetPassword(formData: FormData) {
  const current = formData.get("currentPassword") as string;
  const next = formData.get("newPassword") as string;
  const confirm = formData.get("confirmPassword") as string;

  redirect("/");

  return {
    current,
    next,
    confirm,
  };
}

export async function loginUser(formData: FormData) {
  const username = formData.get("username") as string;
  const password = formData.get("password") as string;

  await new Promise((res) => setTimeout(res, 500));
  redirect("/");
  return {
    password,
    username,
  };
}

export async function loginUserImg(formData: FormData) {
  const username = formData.get("username") as string;
  const password = formData.get("password") as string;

  await new Promise((res) => setTimeout(res, 300));
  redirect("/");
  return {
    password,
    username,
  };
}

export async function verifyOtp(formData: FormData) {
  const otpDigits = [
    formData.get("otp0"),
    formData.get("otp1"),
    formData.get("otp2"),
    formData.get("otp3"),
    formData.get("otp4"),
  ].join("");
  await new Promise((res) => setTimeout(res, 500));
  redirect("/");
  return {
    otpDigits,
  };
}
