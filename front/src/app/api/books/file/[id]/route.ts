import { cookies } from "next/headers";
import { NextRequest, NextResponse } from "next/server";

/**
 * Same-origin proxy for book PDFs/files.
 *
 * The BookReader iframes the book file URL, which lives on the backend API
 * origin. That origin sends `X-Frame-Options: sameorigin`, so the frontend
 * page cannot frame it (and a malformed/empty file_url 404s). This route
 * proxies the file through the frontend origin so the iframe loads same-origin
 * and the framing header is under our control.
 *
 * Access is enforced by reusing the user's auth token (stored as a cookie by
 * `setAuthToken`) to call the backend's `/books/:id/read` endpoint before
 * streaming the file.
 */
export async function GET(
  request: NextRequest,
  { params }: { params: Promise<{ id: string }> }
) {
  const { id } = await params;
  const bookId = parseInt(id, 10);

  if (!bookId) {
    return new NextResponse("Invalid book id", { status: 400 });
  }

  const cookieStore = await cookies();
  const token = cookieStore.get("leacent_auth_token")?.value;

  if (!token) {
    return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  }

  const apiBase =
    process.env.NEXT_PUBLIC_API_BASE_URL || "http://127.0.0.1:8000/api";
  // Strip a trailing "/api" so we can build relative file URLs if needed.
  const apiOrigin = apiBase.replace(/\/api$/, "");

  try {
    // 1. Verify access and resolve the file URL from the backend.
    const readRes = await fetch(`${apiBase}/books/${bookId}/read`, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
      cache: "no-store",
    });

    if (!readRes.ok) {
      if (readRes.status === 404 || readRes.status === 403) {
        return new NextResponse("Book not found or access denied", {
          status: 404,
        });
      }
      return new NextResponse("Failed to verify book access", {
        status: readRes.status,
      });
    }

    const readData = await readRes.json();
    const payload = readData?.data ?? readData;
    const fileUrl = payload?.file_url;

    if (!fileUrl) {
      return new NextResponse("No file available for this book", {
        status: 404,
      });
    }

    // 2. Resolve a fully-qualified file URL (backend may return a relative path).
    const resolvedFileUrl =
      /^https?:\/\//i.test(fileUrl)
        ? fileUrl
        : `${apiOrigin}${fileUrl.startsWith("/") ? "" : "/"}${fileUrl}`;

    // 3. Stream the file from the backend, re-using the user's token.
    const fileRes = await fetch(resolvedFileUrl, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
      cache: "no-store",
    });

    if (!fileRes.ok) {
      return new NextResponse("Failed to load book file", {
        status: fileRes.status,
      });
    }

    const contentType =
      fileRes.headers.get("content-type") || "application/pdf";
    const contentDisposition =
      fileRes.headers.get("content-disposition") ||
      `inline; filename="book-${bookId}.pdf"`;
    const buffer = await fileRes.arrayBuffer();

    return new NextResponse(buffer, {
      status: 200,
      headers: {
        "Content-Type": contentType,
        "Content-Disposition": contentDisposition,
        // Allow the same-origin frontend page to frame this response.
        "X-Frame-Options": "SAMEORIGIN",
        "Cache-Control": "private, max-age=3600",
      },
    });
  } catch (error) {
    console.error("Book file proxy error:", error);
    return new NextResponse("Internal Server Error", { status: 500 });
  }
}
