import api from "./client";

export interface BookPlan {
  id: number;
  name: string;
  slug: string;
  description: string | null;
  price: number;
  points: number;
  currency: string;
  is_featured: boolean;
  features: string[] | null;
}

export interface BankDetails {
  account_name: string;
  account_number: string;
  bank_name: string;
  instructions: string;
}

export type BookPlanPaymentStatus =
  "pending" | "active" | "failed" | "refunded";

export interface BookPlanPayment {
  id: number;
  status: BookPlanPaymentStatus;
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
  points: number;
  plan: BookPlan | null;
  bank: BankDetails;
}

/**
 * Active point packages offered on the pricing page.
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
 * Buy a point package. Creates a pending payment the customer settles
 * by bank transfer; verification happens manually in the admin area.
 */
export function buyPointsPlan(planId: number): Promise<BookPlanPayment> {
  return api.post(`book-plans/${planId}/buy`).then((res) => res.data);
}

/**
 * The authenticated user's point purchase payments.
 */
export function getMyBookPlanPayments(): Promise<BookPlanPayment[]> {
  return api.get("book-plans/payments").then((res) => res.data ?? []);
}

/**
 * Upload the bank transfer receipt for a pending point purchase.
 */
export async function uploadBookPlanReceipt(
  paymentId: number,
  formData: FormData
): Promise<BookPlanPayment> {
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
