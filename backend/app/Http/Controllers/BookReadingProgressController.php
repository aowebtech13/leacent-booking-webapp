<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookAccess;
use App\Models\BookReadingProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookReadingProgressController extends Controller
{
    /**
     * Save or update reading progress for a book.
     *
     * POST /api/books/{id}/progress
     *
     * Body: { current_page, total_pages, progress_percentage, is_completed, cfi? }
     */
    public function update(Request $request, int $bookId)
    {
        $book = Book::where('is_active', true)->findOrFail($bookId);

        $access = BookAccess::query()
            ->where('user_id', $request->user()->id)
            ->where('book_id', $book->id)
            ->active()
            ->first();

        if (! $access && $book->is_premium) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this book.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'current_page' => 'required|integer|min:0',
            'total_pages' => 'nullable|integer|min:0',
            'progress_percentage' => 'nullable|numeric|min:0|max:100',
            'is_completed' => 'nullable|boolean',
            'cfi' => 'nullable|string|max:1024',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $progress = BookReadingProgress::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'book_id' => $book->id,
            ],
            [
                'current_page' => $request->input('current_page'),
                'total_pages' => $request->input('total_pages', $book->page_count),
                'progress_percentage' => $request->input('progress_percentage'),
                'is_completed' => $request->boolean('is_completed', false),
                'completed_at' => $request->boolean('is_completed') ? now() : null,
                'last_read_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'data' => $progress,
        ]);
    }

    /**
     * Get reading progress for a book.
     *
     * GET /api/books/{id}/progress
     */
    public function show(Request $request, int $bookId)
    {
        $progress = BookReadingProgress::query()
            ->where('user_id', $request->user()->id)
            ->where('book_id', $bookId)
            ->first();

        return response()->json([
            'success' => true,
            'data' => $progress,
        ]);
    }

    /**
     * GET /api/reading-progress/latest
     * The authenticated user's most recently-read book, with progress.
     * Used by the dashboard "Book Progress" card.
     */
    public function latest(Request $request)
    {
        $progress = BookReadingProgress::query()
            ->where('user_id', $request->user()->id)
            ->with('book')
            ->latest('last_read_at')
            ->first();

        if (! $progress) {
            return response()->json([
                'success' => true,
                'data' => null,
            ]);
        }

        $book = $progress->book;
        $rangeStart = $progress->last_read_at?->copy()->subDays(14)->format('M j');
        $rangeEnd = $progress->last_read_at?->format('M j, Y') ?? now()->format('M j, Y');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $progress->id,
                'book' => $book ? [
                    'id' => $book->id,
                    'title' => $book->title,
                ] : null,
                'book_title' => $book?->title ?? 'No book',
                'progress_percentage' => (float) ($progress->progress_percentage ?? 0),
                'current_page' => $progress->current_page,
                'total_pages' => $progress->total_pages,
                'is_completed' => $progress->is_completed,
                'last_read_at' => optional($progress->last_read_at)->toIso8601String(),
                'range_start' => $rangeStart,
                'range_end' => $rangeEnd,
            ],
        ]);
    }
}