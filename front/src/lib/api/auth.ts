import api, { setAuthToken } from "./client";
import { bootstrapCsrf } from "./client";

export interface LoginPayload {
  email: string;
  password: string;
}

export interface RegisterPayload {
  name?: string;
  firm_name?: string;
  email: string;
  phone?: string;
  password: string;
  password_confirmation: string;
}

export interface VerifyOtpPayload {
  email: string;
  code: string;
}

export interface ForgotPasswordPayload {
  email: string;
}

export interface ResetPasswordPayload {
  token: string;
  password: string;
  password_confirmation: string;
}

export interface AuthUser {
  id: number;
  name: string;
  email: string;
  profile?: Record<string, any>;
  roles?: Array<{ name: string }>;
}

export interface AuthResponse {
  access_token: string;
  token_type: string;
  user: AuthUser;
}

/**
 * Ensure the CSRF cookie is set before any stateful Sanctum request.
 * Call this once (e.g. in the root layout) and before login/register.
 */
export async function ensureCsrf(): Promise<void> {
  await bootstrapCsrf();
}

/**
 * Register a new user. Backend sends a verification code to the email.
 */
export async function register(payload: RegisterPayload) {
  await ensureCsrf();
  const res = await api.post("auth/register", payload);
  return res.data; // { email } or null
}

/**
 * Log a user in and obtain a Sanctum personal access token.
 */
export async function login(payload: LoginPayload): Promise<AuthResponse> {
  await ensureCsrf();
  const res = await api.post("auth/login", payload);
  const data = res.data as AuthResponse;
  setAuthToken(data.access_token);
  return data;
}

/**
 * Verify the OTP sent during registration / login.
 */
export async function verifyOtp(payload: VerifyOtpPayload): Promise<AuthResponse> {
  await ensureCsrf();
  const res = await api.post("auth/verify-otp", payload);
  const data = res.data as AuthResponse;
  setAuthToken(data.access_token);
  return data;
}

/**
 * Request a password reset link to be emailed to the user.
 */
export async function forgotPassword(payload: ForgotPasswordPayload) {
  await ensureCsrf();
  const res = await api.post("auth/forgot-password", payload);
  return res.data;
}

/**
 * Resend the OTP verification code.
 */
export async function resendOtp(payload: { email: string }) {
  await ensureCsrf();
  const res = await api.post("auth/resend-otp", payload);
  return res.data;
}

/**
 * Reset the user's password using the token emailed during forgot-password.
 */
export async function resetPassword(payload: ResetPasswordPayload) {
  await ensureCsrf();
  const res = await api.post("auth/reset-password", payload);
  return res.data;
}

/**
 * Update the currently authenticated user's profile.
 */
export async function updateProfile(data: {
  full_name?: string;
  avatar_url?: string;
  phone?: string;
  company_name?: string;
  phone_number?: string;
  address?: string;
  about_me?: string;
  facebook_url?: string;
  twitter_url?: string;
  linkedin_url?: string;
}) {
  const res = await api.put("profile", data);
  return res.data;
}

/**
 * Change the currently authenticated user's password.
 */
export async function changePassword(payload: { current_password: string; new_password: string; new_password_confirmation: string }) {
  const res = await api.post("auth/change-password", payload);
  return res.data;
}

/**
 * Fetch the currently authenticated user's profile.
 */
export async function fetchUser(): Promise<AuthUser> {
  const res = await api.get("auth/user");
  return res.data as AuthUser;
}

/**
 * Log the user out (revokes the current Sanctum token).
 */
export async function logout() {
  try {
    await api.post("auth/logout");
  } finally {
    setAuthToken(null);
  }
}