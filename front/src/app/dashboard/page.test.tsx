import { render, screen, waitFor } from "@testing-library/react";
import { describe, it, expect, vi, beforeEach, afterEach } from "vitest";
import DashboardPage from "@/app/dashboard/page";
import { resetApiMock, apiGet } from "@/test/mocks/apiClient";
import { resetAuthMock, setAuthMock } from "@/test/mocks/authContext";

describe("Dashboard page", () => {
  beforeEach(() => {
    resetApiMock();
    resetAuthMock();
    setAuthMock({
      user: { id: 1, name: "Test", email: "test@example.com" },
      isAuthenticated: true,
      isLoading: false,
    });
  });

  afterEach(() => {
    vi.useRealTimers();
  });

  it("renders the EcommerceDashboard for an authenticated user", async () => {
    apiGet.mockImplementation((url: string) => {
      if (url === "profile/points") return Promise.resolve({ data: { points: 100 } });
      if (url === "profile/points-spent") return Promise.resolve({ data: { points_spent: 25 } });
      if (url === "books/total") return Promise.resolve({ data: { total: 5, premium: 2, free: 3 } });
      if (url === "reading-progress/latest") return Promise.resolve({ data: null });
      if (url === "profile/books-spending") return Promise.resolve({ data: { series: [], currency: "NGN" } });
      if (url === "orders") return Promise.resolve({ data: { data: [] } });
      return Promise.resolve({ data: {} });
    });

    render(<DashboardPage />);

    await waitFor(() => {
      expect(screen.getByText(/My Points/i)).toBeInTheDocument();
    });

    expect(screen.getByText("100")).toBeInTheDocument();
    expect(screen.getByText("25")).toBeInTheDocument();
    expect(screen.getByText("5")).toBeInTheDocument();
  });

  it("redirects unauthenticated users to sign-in", async () => {
    setAuthMock({ user: null, isAuthenticated: false, isLoading: false });
    const { container } = render(<DashboardPage />);
    await waitFor(() => {
      expect(container.firstChild).toBeNull();
    });
  });

  it("shows a loading spinner while auth state is resolving", () => {
    setAuthMock({ user: null, isAuthenticated: false, isLoading: true });
    render(<DashboardPage />);
    expect(screen.getByRole("status")).toBeInTheDocument();
  });
});