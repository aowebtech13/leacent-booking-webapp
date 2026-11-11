import { render, screen, waitFor } from "@testing-library/react";
import { describe, it, expect, vi, beforeEach, afterEach } from "vitest";
import EcommerceDetail from "@/Component/Dashboard/EcommerceDashboard/EcommerceDetail";
import { resetApiMock, apiGet } from "@/test/mocks/apiClient";
import { resetAuthMock, setAuthMock } from "@/test/mocks/authContext";

describe("EcommerceDetail", () => {
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

  it("renders recent orders from the backend", async () => {
    apiGet.mockImplementation((url: string) => {
      if (url === "orders") {
        return Promise.resolve({
          data: {
            data: [
              {
                id: 101,
                status: "completed",
                payment_status: "paid",
                updated_at: "2026-11-10T10:00:00Z",
                created_at: "2026-11-05T10:00:00Z",
              },
              {
                id: 102,
                status: "processing",
                payment_status: "pending_verification",
                created_at: "2026-11-08T10:00:00Z",
              },
            ],
          },
        });
      }
      return Promise.resolve({ data: {} });
    });

    render(<EcommerceDetail />);

    await waitFor(() => {
      expect(screen.getByText(/Purchase History/i)).toBeInTheDocument();
    });

    expect(screen.getByText("#101")).toBeInTheDocument();
    expect(screen.getByText("#102")).toBeInTheDocument();
    expect(screen.getByText("Delivered")).toBeInTheDocument();
    expect(screen.getByText("Processing")).toBeInTheDocument();
  });

  it("shows 'No orders found' when the backend returns an empty list", async () => {
    apiGet.mockImplementation((url: string) => {
      if (url === "orders") return Promise.resolve({ data: { data: [] } });
      return Promise.resolve({ data: {} });
    });

    render(<EcommerceDetail />);

    await waitFor(() => {
      expect(screen.getByText(/No orders found/i)).toBeInTheDocument();
    });
  });

  it("does not fetch orders when the user is not authenticated", async () => {
    setAuthMock({ user: null, isAuthenticated: false, isLoading: false });
    render(<EcommerceDetail />);

    await waitFor(() => {
      expect(apiGet).not.toHaveBeenCalled();
    });
  });
});