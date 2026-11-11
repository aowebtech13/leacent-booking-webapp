import { render, screen, waitFor } from "@testing-library/react";
import { describe, it, expect, vi, beforeEach, afterEach } from "vitest";
import EcommerceCard from "@/Component/Dashboard/EcommerceDashboard/EcommerceCard";
import { resetApiMock, apiGet } from "@/test/mocks/apiClient";

describe("EcommerceCard", () => {
  beforeEach(() => {
    resetApiMock();
    apiGet.mockImplementation((url: string) => {
      if (url === "profile/points") return Promise.resolve({ data: { points: 500 } });
      if (url === "profile/points-spent") return Promise.resolve({ data: { points_spent: 120 } });
      if (url === "books/total") return Promise.resolve({ data: { total: 42, premium: 10, free: 32 } });
      if (url === "reading-progress/latest") return Promise.resolve({ data: null });
      if (url === "profile/books-spending") return Promise.resolve({ data: { series: [], currency: "NGN" } });
      return Promise.resolve({ data: {} });
    });
  });

  afterEach(() => {
    vi.useRealTimers();
  });

  it("renders points balance, points spent and books in store from the backend", async () => {
    render(<EcommerceCard />);

    await waitFor(() => {
      expect(screen.getByText("500")).toBeInTheDocument();
    });
    expect(screen.getByText("120")).toBeInTheDocument();
    expect(screen.getByText("42")).toBeInTheDocument();
    expect(screen.getByText(/You haven't read any book yet/i)).toBeInTheDocument();
  });

  it("renders the latest reading progress when available", async () => {
    apiGet.mockImplementation((url: string) => {
      if (url === "profile/points") return Promise.resolve({ data: { points: 500 } });
      if (url === "profile/points-spent") return Promise.resolve({ data: { points_spent: 120 } });
      if (url === "books/total") return Promise.resolve({ data: { total: 42, premium: 10, free: 32 } });
      if (url === "reading-progress/latest") {
        return Promise.resolve({
          data: {
            book_title: "The Great Gatsby",
            progress_percentage: 35,
            range_start: "Oct 28",
            range_end: "Nov 10, 2026",
          },
        });
      }
      if (url === "profile/books-spending") return Promise.resolve({ data: { series: [], currency: "NGN" } });
      return Promise.resolve({ data: {} });
    });

    render(<EcommerceCard />);

    await waitFor(() => {
      expect(screen.getByText("The Great Gatsby")).toBeInTheDocument();
    });
    expect(screen.getByText("35 %")).toBeInTheDocument();
  });

  it("shows a low-points warning when balance is below 3", async () => {
    apiGet.mockImplementation((url: string) => {
      if (url === "profile/points") return Promise.resolve({ data: { points: 2 } });
      if (url === "profile/points-spent") return Promise.resolve({ data: { points_spent: 120 } });
      if (url === "books/total") return Promise.resolve({ data: { total: 42, premium: 10, free: 32 } });
      if (url === "reading-progress/latest") return Promise.resolve({ data: null });
      if (url === "profile/books-spending") return Promise.resolve({ data: { series: [], currency: "NGN" } });
      return Promise.resolve({ data: {} });
    });

    render(<EcommerceCard />);

    await waitFor(() => {
      expect(screen.getByText("2")).toBeInTheDocument();
    });
    expect(screen.getByText(/Low points/i)).toBeInTheDocument();
  });

  it("renders the spending chart with backend data", async () => {
    apiGet.mockImplementation((url: string) => {
      if (url === "profile/points") return Promise.resolve({ data: { points: 500 } });
      if (url === "profile/points-spent") return Promise.resolve({ data: { points_spent: 120 } });
      if (url === "books/total") return Promise.resolve({ data: { total: 42, premium: 10, free: 32 } });
      if (url === "reading-progress/latest") return Promise.resolve({ data: null });
      if (url === "profile/books-spending") {
        return Promise.resolve({
          data: {
            currency: "NGN",
            series: [
              { date: "2026-11-01", amount: 100 },
              { date: "2026-11-02", amount: 200 },
            ],
          },
        });
      }
      return Promise.resolve({ data: {} });
    });

    render(<EcommerceCard />);

    await waitFor(() => {
      const chart = screen.getByTestId("apex-chart");
      const series = JSON.parse(chart.getAttribute("data-series") || "[]");
      expect(series[0].data).toEqual([100, 200]);
    });
  });
});