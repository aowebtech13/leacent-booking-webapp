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
  isbn: string | null;
  publisher: string | null;
  language: string | null;
  category: string | null;
  publication_year: number | null;
  page_count: number | null;
  format: string | null;
  file_path: string | null;
  cover_image_path: string | null;
  preview_path: string | null;
  price: number | string | null;
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
/* Spending                                                           */
/* ------------------------------------------------------------------ */

export interface BooksSpendingPoint {
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
  series: BooksSpendingPoint[];
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
