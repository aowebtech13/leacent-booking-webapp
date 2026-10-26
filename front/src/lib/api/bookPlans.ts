import api from "./client";

export interface BookPlan {
  id: number;
  name: string;
  slug: string;
  description: string | null;
  price: number;
  currency: string;
  billing_cycle: "monthly" | "yearly" | "one_time";
  access_duration_days: number;
  unlimited_books: boolean;
  book_limit: number;
  can_download: boolean;
  can_read_offline: boolean;
  is_featured: boolean;
  features: string[] | null;
}

export interface BankDetails {
  account_name: string;
  account_number: string;
  bank_name: string;
  instructions: string;
}

export interface SubscriptionPlanInfo {
  id: number;
  name: string;
  slug: string;
  description: string | null;
  price: number;
  currency: string;
  billing_cycle: string;
  access_duration_days: number;
  features: string[] | null;
}

export type SubscriptionPaymentStatus =
  "pending" | "active" | "failed" | "refunded" | "expired";

export interface SubscriptionPayment {
  id: number;
  status: SubscriptionPaymentStatus;
  amount: number;
  currency: string;
  payment_method: string | null;
  payment_reference: string | null;
  notes: string | null;
  rejection_reason: string | null;
  has_receipt: boolean;
  receipt_url: string | null;
  paid_at: string | null;
  verified_at: string | null;
  created_at: string | null;
  plan: SubscriptionPlanInfo | null;
  bank: BankDetails;
}

/**
 * Active subscription plans offered on the pricing page.
 */
export function getBookPlans(): Promise<BookPlan[]> {
  return api.get("book-plans").then((res) => res.data ?? []);
}

/**
 * Bank account details used for manual (bank transfer) payments.
 */
export function getBankDetails(): Promise<BankDetails> {
  return api.get("book-plans/bank-details").then((res) => res.data);
}

/**
 * Start a subscription. Creates a pending payment the customer settles
 * by bank transfer; verification happens manually in the admin area.
 */
export function subscribeToPlan(planId: number): Promise<SubscriptionPayment> {
  return api.post(`book-plans/${planId}/subscribe`).then((res) => res.data);
}

/**
 * The authenticated user's subscription payments.
 */
export function getMySubscriptionPayments(): Promise<SubscriptionPayment[]> {
  return api.get("book-plans/payments").then((res) => res.data ?? []);
}

/**
 * Upload the bank transfer receipt for a pending subscription payment.
 */
export async function uploadSubscriptionReceipt(
  paymentId: number,
  formData: FormData
): Promise<SubscriptionPayment> {
  const instance = (await import("axios")).default.create({
    baseURL: api.defaults.baseURL ?? "",
    withCredentials: true,
    headers: {
      Accept: "application/json",
      ...(api.defaults.headers.common?.Authorization
        ? { Authorization: api.defaults.headers.common.Authorization as string }
        : {}),
    },
    timeout: 30000,
  });
  const res = await instance.post(
    `book-plans/payments/${paymentId}/receipt`,
    formData
  );
  const body = res.data;
  if (body && typeof body === "object" && "success" in body) {
    if (body.success === false)
      throw new Error(body.message || "Request failed");
    return body.data ?? body;
  }
  return body;
}
