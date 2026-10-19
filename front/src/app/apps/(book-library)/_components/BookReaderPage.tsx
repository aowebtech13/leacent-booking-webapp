"use client";

import React, { useEffect, useState } from "react";
import {
  Col,
  Container,
  Row,
  Button,
  Spinner,
  Alert,
} from "reactstrap";
import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";
import { useParams, useRouter } from "next/navigation";
import { getBookRead, Book } from "@/lib/api/books";
import { BookReader } from "@/Component/BookReader/BookReader";
import { useReadingProgress } from "@/hooks/useReadingProgress";
import { IconBook, IconArrowLeft, IconRefresh } from "@tabler/icons-react";

const BookReaderPage = () => {
  const params = useParams();
  const router = useRouter();
  const bookId = params.id ? parseInt(params.id as string, 10) : null;

  const [book, setBook] = useState<Book | null>(null);
  const [fileUrl, setFileUrl] = useState<string | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [readerLocation, setReaderLocation] = useState<string | number | null>(null);

  const { progress, loadProgress, saveProgress, isLoading: isProgressLoading } =
    useReadingProgress();

  const fetchBook = async () => {
    if (!bookId) {
      setError("Invalid book ID");
      setIsLoading(false);
      return;
    }
    setIsLoading(true);
    setError(null);
    try {
      const res = await getBookRead(bookId);
      const data = res;
      setBook(data.book);
      setFileUrl(data.file_url);
      // Load saved progress
      const saved = await loadProgress(bookId);
      if (saved?.progress_percentage) {
        // Store the CFI or location to restore
        setReaderLocation(saved.progress_percentage as any);
      }
    } catch (err: any) {
      setError(err?.message || "Failed to load book. You may not have access to this book.");
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    fetchBook();
  }, [bookId]);

  const handleLocationChange = (location: any) => {
    // location contains: fraction, section, location, time, cfi
    if (location?.cfi) {
      setReaderLocation(location.cfi);
    }
  };

  const handleSaveProgress = async () => {
    if (!bookId || !book) return;
    try {
      // We need to extract current page from the reader
      // The onLocationChange already captures the CFI
      if (readerLocation) {
        await saveProgress(bookId, {
          current_page: Math.round((progress?.progress_percentage as number) || 0),
          total_pages: book.page_count || 0,
          progress_percentage: progress?.progress_percentage as number || 0,
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

  if (error || !book || !fileUrl) {
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
              <p className="mb-3">{error || "Book not found or access denied."}</p>
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
    <div className="book-reader-page" style={{ height: "100vh", display: "flex", flexDirection: "column" }}>
      {/* Top Bar */}
      <nav className="navbar navbar-light bg-white border-bottom px-3" style={{ zIndex: 100 }}>
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
            <h5 className="mb-0 fw-medium" style={{ maxWidth: "600px", whiteSpace: "nowrap", overflow: "hidden", textOverflow: "ellipsis" }}>
              {book.title}
            </h5>
            <small className="text-muted">{book.author || "Unknown Author"}</small>
          </div>
          <div className="d-flex align-items-center gap-2">
            {progressPercent > 0 && (
              <span className="badge bg-primary px-3 py-2">
                {progressPercent}% read
              </span>
            )}
            <Button color="outline-secondary" size="sm" onClick={handleSaveProgress} disabled={isProgressLoading}>
              <IconRefresh size={16} className={isProgressLoading ? "fa-spin" : ""} />
              Save Progress
            </Button>
          </div>
        </div>
      </nav>

      {/* Reader */}
      <main style={{ flex: 1, overflow: "hidden" }}>
        <BookReader
          url={fileUrl}
          location={readerLocation}
          title={book.title}
          showToc={true}
          onLocationChange={handleLocationChange}
          style={{ height: "100%" }}
        />
      </main>

      {/* Bottom Progress Bar (optional) */}
      <div className="bg-light border-top px-3 py-2">
        <div className="d-flex align-items-center justify-content-between small text-muted">
          <span>
            {progress
              ? `Last read: ${new Date(progress.last_read_at ?? "").toLocaleDateString()}`
              : "First time reading"}
          </span>
          {book.page_count && (
            <span>Page {progress?.current_page || 1} of {book.page_count}</span>
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