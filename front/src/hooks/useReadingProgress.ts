import { useCallback, useState } from "react";
import { useAuth } from "@/lib/contexts/AuthContext";
import { api } from "@/lib/api";

export interface ReadingProgress {
  id: number;
  user_id: number;
  book_id: number;
  current_page: number;
  total_pages: number;
  progress_percentage: number | string | null;
  last_read_at: string | null;
  is_completed: boolean;
  completed_at: string | null;
}

interface ProgressResponse {
  success: boolean;
  data: ReadingProgress | null;
}

interface SaveProgressResponse {
  success: boolean;
  data: ReadingProgress;
}

interface UseReadingProgressResult {
  progress: ReadingProgress | null;
  isLoading: boolean;
  error: string | null;
  loadProgress: (bookId: number) => Promise<ReadingProgress | null>;
  saveProgress: (
    bookId: number,
    data: {
      current_page: number;
      total_pages?: number;
      progress_percentage?: number;
      is_completed?: boolean;
      cfi?: string;
    }
  ) => Promise<ReadingProgress | null>;
  clearError: () => void;
}

/**
 * Hook for fetching and persisting a user's reading progress for a book.
 * Requires an authenticated user (Sanctum token).
 */
export function useReadingProgress(): UseReadingProgressResult {
  const { isAuthenticated } = useAuth();
  const [progress, setProgress] = useState<ReadingProgress | null>(null);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const clearError = useCallback(() => setError(null), []);

  const loadProgress = useCallback(
    async (bookId: number): Promise<ReadingProgress | null> => {
      if (!isAuthenticated) return null;
      setIsLoading(true);
      setError(null);
      try {
        const res = await api.get<ProgressResponse>(`books/${bookId}/progress`);
        const data = (res.data as ProgressResponse).data ?? null;
        setProgress(data);
        return data;
      } catch (err: any) {
        setError(err?.message || "Failed to load reading progress");
        return null;
      } finally {
        setIsLoading(false);
      }
    },
    [isAuthenticated]
  );

  const saveProgress = useCallback(
    async (
      bookId: number,
      data: {
        current_page: number;
        total_pages?: number;
        progress_percentage?: number;
        is_completed?: boolean;
        cfi?: string;
      }
    ): Promise<ReadingProgress | null> => {
      if (!isAuthenticated) return null;
      setError(null);
      try {
        const res = await api.post<SaveProgressResponse>(
          `books/${bookId}/progress`,
          data
        );
        const saved = (res.data as SaveProgressResponse).data;
        setProgress(saved);
        return saved;
      } catch (err: any) {
        setError(err?.message || "Failed to save reading progress");
        return null;
      }
    },
    [isAuthenticated]
  );

  return {
    progress,
    isLoading,
    error,
    loadProgress,
    saveProgress,
    clearError,
  };
}

export default useReadingProgress;
