import { vi } from "vitest";

/**
 * Shared mock factory for the axios-based API client used across the app.
 *
 * Each module that calls `api.get`/`api.post` will receive a jest-style
 * mock whose resolved value is controlled per-test via `__setMockResponse`.
 */

export const apiGet = vi.fn();
export const apiPost = vi.fn();

export function resetApiMock() {
  apiGet.mockReset();
  apiPost.mockReset();
}

vi.mock("@/lib/api/client", () => ({
  default: {
    get: (...args: any[]) => apiGet(...args),
    post: (...args: any[]) => apiPost(...args),
    put: vi.fn(),
    delete: vi.fn(),
    interceptors: { request: { use: vi.fn() }, response: { use: vi.fn() } },
    defaults: { headers: { common: {} } },
  },
  setAuthToken: vi.fn(),
  safeRequest: vi.fn(),
  avatarUrl: (url?: string | null) => url ?? undefined,
  bootstrapCsrf: vi.fn(),
}));