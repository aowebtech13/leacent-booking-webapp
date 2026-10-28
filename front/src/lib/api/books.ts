import api from "./client";

export interface Author {
  id: number;
  name: string;
  slug: string;
  bio: string | null;
  email: string | null;
  phone: string | null;
  website: string | null;
  avatar: string | null;
  is_active: boolean;
  books_count?: number;
  created_at?: string;
  updated_at?: string;
}

export interface Book {
  id: number;
  title: string;
  slug: string;
  description: string | null;
  author: string | null;
  author_id: number | null;
  authorDetail?: Author | null;
  publisher: string | null;
  language: string | null;
  category: string | null;
  publication_year: number | null;
  page_count: number | null;
  format: string | null;
  file_path: string | null;
  cover_image_path: string | null;
  preview_path: string | null;
  is_premium: boolean;
  is_active: boolean;
  is_featured: boolean;
  read_count: number;
  download_count: number;
  rating: number | string | null;
  reviews_count: number;
  tags: string[] | null;
  file_url: string | null;
  cover_url: string | null;
  preview_url: string | null;
  can_access?: boolean;
  access_type?: string | null;
  access_expires_at?: string | null;
}

export interface BookListMeta {
  current_page: number;
  per_page: number;
  total: number;
  last_page: number;
}

export interface BookListResponse {
  data: Book[];
  meta?: BookListMeta;
  links?: {
    first: string;
    last: string;
    prev: string | null;
    next: string | null;
  };
}

export interface BookTotalResponse {
  total: number;
  premium: number;
  free: number;
}

/* ------------------------------------------------------------------ */
/* Categories                                                         */
/* ------------------------------------------------------------------ */

export interface Category {
  id: number;
  name: string;
  slug: string;
  description: string | null;
  products_count?: number;
  status?: string;
}

export function getCategories(): Promise<Category[]> {
  return api.get("categories").then((res) => res.data ?? []);
}

/**
 * Latest subscription book-plan payment for the authenticated user.
 * Returns the payment object or null.
 */
export function getLatestBookPlanTransaction(): Promise<any> {
  return api
    .get("profile/book-plan-transaction")
    .then((res) => res.data ?? null);
}

export interface BookReadResponse {
  book: Book;
  file_url: string;
  access: {
    id: number;
    access_type: string;
    granted_at: string;
    expires_at: string | null;
    is_active: boolean;
  };
}

export interface BooksQuery {
  search?: string;
  category?: string;
  premium?: boolean;
  featured?: boolean;
  sort?: string;
  direction?: "asc" | "desc";
  per_page?: number;
  page?: number;
}

/**
 * List active books with optional filters (public).
 */
export function getBooks(query: BooksQuery = {}): Promise<BookListResponse> {
  const params: Record<string, any> = {};
  if (query.search) params.search = query.search;
  if (query.category) params.category = query.category;
  if (query.premium !== undefined) params.premium = query.premium;
  if (query.featured !== undefined) params.featured = query.featured;
  if (query.sort) params.sort = query.sort;
  if (query.direction) params.direction = query.direction;
  if (query.per_page) params.per_page = query.per_page;
  return api.get("books", { params });
}

/**
 * Total counts of active books (public).
 */
export function getBooksTotal(): Promise<BookTotalResponse> {
  return api.get("books/total");
}

/**
 * Get a single book by id, including access status for authenticated users.
 */
export function getBook(id: number): Promise<Book> {
  return api.get(`books/${id}`);
}

/**
 * Get the preview URL for a book (public).
 */
export function getBookPreview(
  id: number
): Promise<{ preview_url: string | null }> {
  return api.get(`books/${id}/preview`);
}

/**
 * Get the book file URL for an authenticated user with active access.
 */
export function getBookRead(id: number): Promise<BookReadResponse> {
  return api.get(`books/${id}/read`);
}

/* ------------------------------------------------------------------ */
/* Spending                                                           */
/* ------------------------------------------------------------------ */

export interface BooksSpendingSeriesItem {
  date: string;
  amount: number;
}

export interface BooksSpendingResponse {
  total: number;
  currency: string;
  purchases: number;
  last_week: number;
  previous_week: number;
  change_percent: number | null;
  series: BooksSpendingSeriesItem[];
}

/**
 * Money the authenticated user spent on books, plus a daily breakdown
 * used by the dashboard "Money Spent" chart.
 */
export function getBooksSpending(): Promise<BooksSpendingResponse> {
  return api.get("profile/books-spending");
}

export interface BookReadingStats {
  completed_books: number;
  in_progress_books: number;
  total_progress_entries: number;
}

export function getBookReadingStats(): Promise<BookReadingStats> {
  return api.get("profile/book-reading-stats");
}

export interface MoneySpentResponse {
  total_spent: number;
  currency: string;
}

export function getMoneySpent(): Promise<MoneySpentResponse> {
  return api.get("profile/money-spent");
}
