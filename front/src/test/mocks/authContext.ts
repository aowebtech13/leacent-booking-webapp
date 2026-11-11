import { vi } from "vitest";

/**
 * Mock the AuthContext so dashboard tests can toggle auth state without
 * spinning up the full AuthProvider (which would call the real API).
 */

export const authState = {
  user: null as any,
  isAuthenticated: false,
  isLoading: false,
};

export function setAuthMock(state: Partial<typeof authState>) {
  Object.assign(authState, state);
}

export function resetAuthMock() {
  authState.user = null;
  authState.isAuthenticated = false;
  authState.isLoading = false;
}

vi.mock("@/lib/contexts/AuthContext", () => ({
  useAuth: () => ({ ...authState }),
  AuthProvider: ({ children }: any) => children,
}));