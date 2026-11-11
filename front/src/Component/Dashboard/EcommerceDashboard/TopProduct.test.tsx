import { render, screen, waitFor } from "@testing-library/react";
import { describe, it, expect, vi, beforeEach, afterEach } from "vitest";
import TopProduct from "@/Component/Dashboard/EcommerceDashboard/TopProduct";
import { resetApiMock, apiGet } from "@/test/mocks/apiClient";

describe("TopProduct", () => {
  beforeEach(() => {
    resetApiMock();
  });

  afterEach(() => {
    vi.useRealTimers();
  });

  it("renders top books from the backend sorted by read_count", async () => {
    apiGet.mockImplementation((url: string) => {
      if (url === "books") {
        return Promise.resolve({
          data: {
            data: [
              {
                id: 1,
                title: "Book A",
                read_count: 300,
                points: 50,
                rating: 4.5,
              },
              {
                id: 2,
                title: "Book B",
                read_count: 180,
                points: 30,
                rating: 4.0,
              },
            ],
          },
        });
      }
      if (url === "authors") {
        return Promise.resolve([
          { id: 1, name: "Author One", books_count: 5, avatar: null },
          { id: 2, name: "Author Two", books_count: 3, avatar: null },
        ]);
      }
      return Promise.resolve({ data: {} });
    });

    render(<TopProduct />);

    await waitFor(() => {
      expect(screen.getByText("Book A")).toBeInTheDocument();
    });
    expect(screen.getByText("Book B")).toBeInTheDocument();
    expect(screen.getByText("300")).toBeInTheDocument();
    expect(screen.getByText("180")).toBeInTheDocument();
    expect(screen.getByText("50 pts")).toBeInTheDocument();
    expect(screen.getByText("30 pts")).toBeInTheDocument();
  });

  it("renders authors by books count", async () => {
    apiGet.mockImplementation((url: string) => {
      if (url === "books") {
        return Promise.resolve({ data: { data: [] } });
      }
      if (url === "authors") {
        return Promise.resolve([
          { id: 1, name: "Author One", books_count: 5, avatar: null },
        ]);
      }
      return Promise.resolve({ data: {} });
    });

    render(<TopProduct />);

    await waitFor(() => {
      expect(screen.getByText("Author One")).toBeInTheDocument();
    });
    expect(screen.getByText("5 Books")).toBeInTheDocument();
  });

  it("shows an error state when the books endpoint fails", async () => {
    apiGet.mockImplementation((url: string) => {
      if (url === "books") return Promise.reject(new Error("Failed to load top products"));
      if (url === "authors") return Promise.resolve([]);
      return Promise.resolve({ data: {} });
    });

    render(<TopProduct />);

    await waitFor(() => {
      expect(screen.getByText(/Failed to load top products/i)).toBeInTheDocument();
    });
  });
});