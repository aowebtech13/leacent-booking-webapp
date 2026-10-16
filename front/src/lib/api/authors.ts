import api from "./client";
import type { Author } from "./books";

export interface AuthorListResponse {
  data: Author[];
  meta?: {
    current_page: number;
    per_page: number;
    total: number;
    last_page: number;
  };
  links?: {
    first: string;
    last: string;
    prev: string | null;
    next: string | null;
  };
}

export interface AuthorQuery {
  search?: string;
  is_active?: boolean;
  per_page?: number;
}

export interface CreateAuthorInput {
  name: string;
  slug?: string;
  bio?: string | null;
  email?: string | null;
  phone?: string | null;
  website?: string | null;
  avatar?: string | null;
  is_active?: boolean;
}

export interface UpdateAuthorInput extends Partial<CreateAuthorInput> {}

/**
 * List all authors with optional search and pagination.
 */
export function getAuthors(query: AuthorQuery = {}): Promise<AuthorListResponse> {
  const params: Record<string, any> = {};
  if (query.search) params.search = query.search;
  if (query.is_active !== undefined) params.is_active = query.is_active;
  if (query.per_page) params.per_page = query.per_page;
  return api.get("admin/authors", { params });
}

/**
 * List active authors (public) for the frontend team directory.
 * Resolves to the authors array directly.
 */
export function getPublicAuthors(): Promise<Author[]> {
  return api.get("authors").then((res) => res.data ?? []);
}

/**
 * Get a single author by id or slug.
 */
export function getAuthor(id: number | string): Promise<Author> {
  return api.get(`admin/authors/${id}`);
}

/**
 * Create a new author.
 */
export function createAuthor(data: CreateAuthorInput): Promise<Author> {
  return api.post("admin/authors", data);
}

/**
 * Update an author.
 */
export function updateAuthor(id: number | string, data: UpdateAuthorInput): Promise<Author> {
  return api.put(`admin/authors/${id}`, data);
}

/**
 * Delete an author.
 */
export function deleteAuthor(id: number | string): Promise<void> {
  return api.delete(`admin/authors/${id}`);
}
