import axios, { type AxiosInstance, type AxiosResponse } from "axios";

/**
 * Base axios instance configured to talk to the Laravel backend.
 *
 * The backend is served at `http://127.0.0.1:8000` (see `NEXT_PUBLIC_API_BASE_URL`).
 * All API routes are namespaced under `/api` (Laravel route prefix), so the
 * base URL already includes `/api` and individual modules use relative paths
 * such as `auth/login`.
 */
const api: AxiosInstance = axios.create({
  baseURL: process.env.NEXT_PUBLIC_API_BASE_URL || "http://127.0.0.1:8000/api",
  withCredentials: true, // required for Sanctum stateful cookies (CSRF + session)
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
  timeout: 30000,
});

/**
 * Attach the Bearer token (Sanctum personal access token) returned by the
 * login endpoint to outgoing requests when one is available in the store.
 */
export function setAuthToken(token: string | null) {
  if (token) {
    api.defaults.headers.common.Authorization = `Bearer ${token}`;
  } else {
    delete api.defaults.headers.common.Authorization;
  }
}

/**
 * Response interceptor that unwraps the standard Laravel envelope used by
 * this project:
 *
 *   { success: boolean, message?: string, data?: any, errors?: object }
 *
 * It resolves with the `data` payload and rejects with a structured error
 * containing the backend message / validation errors.
 */
api.interceptors.response.use(
  (response: AxiosResponse) => {
    const body = response.data;

    // Binary / non-JSON payloads (e.g. file downloads) pass through untouched.
    if (body === undefined || body === null) {
      return response;
    }

    // Standard envelope: { success, message, data }
    if (typeof body === "object" && "success" in body) {
      if (body.success === false) {
        const err = new Error(body.message || "Request failed");
        (err as any).response = response;
        (err as any).data = body;
        (err as any).status = response.status;
        return Promise.reject(err);
      }
      // Replace the envelope with the inner payload for convenience.
      return { ...response, data: body.data ?? body };
    }

    return response;
  },
  (error) => {
    const data = error?.response?.data;
    const backendMessage =
      data?.message ||
      (data?.errors ? Object.values(data.errors).flat().join(" ") : null);

    let message: string;
    if (backendMessage) {
      message = backendMessage;
    } else if (error?.response) {
      message = error?.message || "Something went wrong";
    } else {
      message = "Unable to connect to the server. Please try again later.";
    }

    const err = new Error(message);
    (err as any).response = error?.response;
    (err as any).data = data;
    (err as any).status = error?.response?.status;
    (err as any).code = error?.code;
    return Promise.reject(err);
  }
);

export default api;

/**
 * Bootstrap CSRF cookie before any stateful Sanctum request.
 * Safe to call multiple times; guarded by a module-level flag.
 */
let csrfBootstrapped = false;
export async function bootstrapCsrf(): Promise<void> {
  if (csrfBootstrapped) return;
  csrfBootstrapped = true;
  try {
    await axios.get("/sanctum/csrf-cookie", {
      baseURL:
        process.env.NEXT_PUBLIC_API_BASE_URL?.replace(/\/api$/, "") ||
        "http://127.0.0.1:8000",
      withCredentials: true,
    });
  } catch {
    // Non-fatal: CSRF cookie fetch failures shouldn't block the app.
  }
}
