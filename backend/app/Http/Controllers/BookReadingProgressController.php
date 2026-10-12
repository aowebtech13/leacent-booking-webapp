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
}