"use client";

import React, { useEffect, useState } from "react";
import { Col, Container, Row, Button, Spinner, Alert } from "reactstrap";
import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";
import { useParams, useRouter } from "next/navigation";
import { notFound } from "next/navigation";
import { getBook, getBookRead, Book } from "@/lib/api/books";
import { BookReader } from "@/Component/BookReader/BookReader";
import { useReadingProgress } from "@/hooks/useReadingProgress";
import { IconBook, IconArrowLeft, IconRefresh } from "@tabler/icons-react";

const BookReaderPage = () => {
  const params = useParams();
  const router = useRouter();
  const bookId = params.id ? parseInt(params.id as string, 10) : null;

  const [book, setBook] = useState<Book | null>(null);
  const [blobUrl, setBlobUrl] = useState<string | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [readerLocation, setReaderLocation] = useState<string | number | null>(
    null
  );

  const {
    progress,
    loadProgress,
    saveProgress,
    isLoading: isProgressLoading,
  } = useReadingProgress();

  const resolveFileUrl = (url: string | null): string | null => {
    if (!url) return null;
    if (/^https?:\/\//i.test(url)) return url;
    const origin = process.env.NEXT_PUBLIC_API_BASE_URL?.replace(/\/api$/, "") || "";
    if (!origin) return url;
    return `${origin}${url.startsWith("/") ? "" : "/"}${url}`;
  };

  const fetchBook = async () => {
    if (!bookId) {
      setError("Invalid book ID");
      setIsLoading(false);
      return;
    }
    setIsLoading(true);
    setError(null);
    try {
      // Track the file URL in a local variable. Reading it back from state
      // (fileUrl) right after setFileUrl() would return the stale value from
      // the render that created this closure (null on mount), which made every
      // book appear to have no file uploaded.
      let readableFileUrl: string | null = null;
      let specificError: string | null = null;

      try {
        const res = await getBookRead(bookId);
        setBook(res.book);
        readableFileUrl = res.file_url;
      } catch (readErr: any) {
        // The read endpoint failed (no access / no file uploaded). Fall back
        // to the public book endpoint to tell "book missing" apart from
        // "book exists but is not readable".
        let details: Book | null = null;
        try {
          details = await getBook(bookId);
        } catch (bookErr: any) {
          // Public endpoint also failed → book itself doesn't exist.
          throw bookErr;
        }
        setBook(details);
        if (details?.file_url) {
          // Public file URL available as a fallback.
          readableFileUrl = details.file_url;
        } else {
          // Book exists but is not readable (no access or no file uploaded).
          // Surface the backend's message instead of a generic error.
          specificError =
            readErr?.message || "Book file is not available yet.";
        }
      }

      const saved = await loadProgress(bookId);
      if (saved?.progress_percentage) {
        setReaderLocation(saved.progress_percentage as any);
      }

      // Load the book file as a blob so the iframe renders from a same-origin
      // URL, avoiding cross-origin X-Frame-Options blocking on the backend.
      const resolved = resolveFileUrl(readableFileUrl);
      if (resolved) {
        try {
          // Book files are public (Cloudinary / public storage disk), so the
          // download must be credential-less. The shared axios `api` instance
          // sends withCredentials, which makes Cloudinary's wildcard
          // Access-Control-Allow-Origin invalid ("credentials mode include").
          const res = await fetch(resolved, {
            credentials: "omit",
            mode: "cors",
          });
          if (!res.ok) {
            throw new Error(
              `Failed to fetch book file (HTTP ${res.status}).`
            );
          }
          const blob = await res.blob();
          const objectUrl = URL.createObjectURL(blob);
          setBlobUrl(objectUrl);
        } catch (blobErr: any) {
          setError(
            blobErr?.message ||
              "Failed to load the book file. Please try again later."
          );
        }
      } else if (specificError) {
        setError(specificError);
      } else {
        setError(
          "This book doesn't have a file uploaded. Please contact support or try another book."
        );
      }
    } catch (err: any) {
      const status = err?.status;
      // 404 = book doesn't exist or has no file → trigger Next.js 404 page
      if (status === 404) {
        notFound();
      }
      setError(
        err?.message ||
          "Failed to load book. You may not have access to this book."
      );
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    fetchBook();
  }, [bookId]);

  useEffect(() => {
    return () => {
      if (blobUrl) {
        URL.revokeObjectURL(blobUrl);
      }
    };
  }, [blobUrl]);

  const handleLocationChange = (location: any) => {
    if (location?.cfi) {
      setReaderLocation(location.cfi);
    }
  };

  const handleSaveProgress = async () => {
    if (!bookId || !book) return;
    try {
      if (readerLocation) {
        await saveProgress(bookId, {
          current_page: Math.round(
            (progress?.progress_percentage as number) || 0
          ),
          total_pages: book.page_count || 0,
          progress_percentage: (progress?.progress_percentage as number) || 0,
          is_completed: (progress?.progress_percentage as number) >= 100,
        });
      }
    } catch (err) {
      console.error("Failed to save progress:", err);
    }
  };

  const goBack = () => {
    router.back();
  };

  if (isLoading) {
    return (
      <Container fluid>
        <Breadcrumbs
          mainTitle="Loading..."
          title="Apps"
          path={["Book Library", "Reading"]}
          Icon={IconBook as any}
        />
        <Row className="justify-content-center mt-5">
          <Col xs={12} className="text-center">
            <Spinner color="primary" size="lg" />
            <p className="mt-2 text-muted">Loading book...</p>
          </Col>
        </Row>
      </Container>
    );
  }

  if (error || !book || !blobUrl) {
    return (
      <Container fluid>
        <Breadcrumbs
          mainTitle="Error"
          title="Apps"
          path={["Book Library", "Error"]}
          Icon={IconBook as any}
        />
        <Row className="justify-content-center mt-5">
          <Col md={8}>
            <Alert color="danger" className="text-center py-5">
              <IconBook size={48} className="mb-3" />
              <h4>Unable to Load Book</h4>
              <p className="mb-3">
                {error || "Book not found or access denied."}
              </p>
              <Button color="secondary" onClick={goBack}>
                <IconArrowLeft size={16} className="me-1" />
                Back to Library
              </Button>
            </Alert>
          </Col>
        </Row>
      </Container>
    );
  }

  const progressPercent = progress?.progress_percentage
    ? Math.round(Number(progress.progress_percentage))
    : 0;

  return (
    <div
      className="book-reader-page"
      style={{ height: "100vh", display: "flex", flexDirection: "column" }}
    >
      <nav
        className="navbar navbar-light bg-white border-bottom px-3"
        style={{ zIndex: 100 }}
      >
        <div className="d-flex align-items-center w-100">
          <Button
            color="link"
            className="text-dark me-2"
            onClick={goBack}
            style={{ padding: "0.25rem 0.5rem" }}
          >
            <IconArrowLeft size={20} />
          </Button>
          <div className="flex-grow-1 text-center">
            <h5
              className="mb-0 fw-medium"
              style={{
                maxWidth: "600px",
                whiteSpace: "nowrap",
                overflow: "hidden",
                textOverflow: "ellipsis",
              }}
            >
              {book.title}
            </h5>
            <small className="text-muted">
              {book.author || book.authorDetail?.name || "Unknown Author"}
            </small>
          </div>
          <div className="d-flex align-items-center gap-2">
            {progressPercent > 0 && (
              <span className="badge bg-primary px-3 py-2">
                {progressPercent}% read
              </span>
            )}
            <Button
              color="outline-secondary"
              size="sm"
              onClick={handleSaveProgress}
              disabled={isProgressLoading}
            >
              <IconRefresh
                size={16}
                className={isProgressLoading ? "fa-spin" : ""}
              />
              Save Progress
            </Button>
          </div>
        </div>
      </nav>

      <main
        style={{ flex: 1, overflow: "hidden" }}
        onContextMenu={(e) => e.preventDefault()}
      >
        <BookReader
          url={blobUrl}
          isPdf={true}
          location={readerLocation}
          title={book.title}
          showToc={true}
          onLocationChange={handleLocationChange}
          style={{ height: "100%" }}
        />
      </main>

      <div className="bg-light border-top px-3 py-2">
        <div className="d-flex align-items-center justify-content-between small text-muted">
          <span>
            {progress
              ? `Last read: ${new Date(progress.last_read_at ?? "").toLocaleDateString()}`
              : "First time reading"}
          </span>
          {book.page_count && (
            <span>
              Page {progress?.current_page || 1} of {book.page_count}
            </span>
          )}
        </div>
        {progressPercent > 0 && (
          <div className="progress mt-2" style={{ height: "4px" }}>
            <div
              className="progress-bar bg-primary"
              role="progressbar"
              style={{ width: `${progressPercent}%` }}
              aria-valuenow={progressPercent}
              aria-valuemin={0}
              aria-valuemax={100}
            />
          </div>
        )}
      </div>
    </div>
  );
};

export default BookReaderPage;
