"use client";

import React, { useEffect, useState, useCallback } from "react";
import {
  Card,
  CardBody,
  Col,
  Container,
  Row,
  Button,
  Spinner,
  Alert,
  Input,
  InputGroup,
  InputGroupText,
  FormGroup,
  Label,
} from "reactstrap";
import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";
import BookLibrarySidebar from "@/app/apps/(book-library)/_components/BookLibrarySidebar";
import { getBooks, Book, unlockBook } from "@/lib/api/books";
import { IconBook, IconSearch, IconFileText } from "@tabler/icons-react";
import { useRouter } from "next/navigation";
import Image from "next/image";
import toast from "@/Component/Services/toast";

const BookLibraryPage = () => {
  const [activeTab, setActiveTab] = useState("1");
  const [books, setBooks] = useState<Book[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [searchQuery, setSearchQuery] = useState("");
  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [unlocking, setUnlocking] = useState<Set<number>>(new Set());
  const router = useRouter();

  const fetchBooks = useCallback(async () => {
    setIsLoading(true);
    setError(null);
    try {
      const query: any = { per_page: 12, page: currentPage };
      if (searchQuery) query.search = searchQuery;
      const res = await getBooks(query);
      const payload = (res as any).data ?? res;
      const booksData = Array.isArray(payload)
        ? payload
        : Array.isArray((payload as any).data)
          ? (payload as any).data
          : [];
      setBooks(booksData);
      const meta = (payload as any).meta ?? (res as any).meta;
      if (meta) {
        setCurrentPage(meta.current_page ?? currentPage);
        setLastPage(meta.last_page ?? 1);
      } else if ((payload as any).current_page) {
        setCurrentPage((payload as any).current_page ?? currentPage);
        setLastPage((payload as any).last_page ?? 1);
      } else {
        setLastPage(1);
      }
    } catch (err: any) {
      setError(err?.message || "Failed to load books");
    } finally {
      setIsLoading(false);
    }
  }, [currentPage, searchQuery]);

  useEffect(() => {
    fetchBooks();
  }, [fetchBooks]);

  const handleRead = (book: Book) => {
    if (!book.file_url) {
      toast.error("This book doesn't have a file available yet. Please contact support.");
      return;
    }
    router.push(`/apps/book-library/read/${book.id}`);
  };

  const handlePreview = (book: Book) => {
    if (book.preview_url) {
      window.open(book.preview_url, "_blank", "noopener,noreferrer");
    }
  };

  const handleUnlock = async (book: Book) => {
    if (unlocking.has(book.id)) return;
    setUnlocking((prev) => new Set(prev).add(book.id));
    setError(null);
    try {
      const res = await unlockBook(book.id);
      const remaining = res?.points_remaining;
      toast.success(
        `Unlocked "${book.title}"${typeof remaining === "number" ? `. ${remaining} point${remaining === 1 ? "" : "s"} remaining.` : "."}`
      );
      setBooks((prev) =>
        prev.map((b) =>
          b.id === book.id
            ? { ...b, can_access: true, access_type: "points" }
            : b
        )
      );
      // Allow toast to appear before navigation
      await new Promise((r) => setTimeout(r, 500));
      router.push(`/apps/book-library/read/${book.id}`);
    } catch (err: any) {
      const message = err?.message || "Failed to unlock book";
      const insufficient =
        err?.status === 403 || /insufficient points/i.test(message);
      if (insufficient) {
        if (typeof window !== "undefined") {
          const { default: Swal } = await import("sweetalert2");
          await Swal.fire({
            title: "Not enough points",
            text: `You need ${book.points} point${book.points === 1 ? "" : "s"} to unlock this book. Buy more points to continue.`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Buy points",
            cancelButtonText: "Not now",
            confirmButtonColor: "#3085d6",
          }).then((result) => {
            if (result.isConfirmed) router.push("/apps/pricing");
          });
        }
        return;
      }
      toast.error(message);
    } finally {
      setUnlocking((prev) => {
        const next = new Set(prev);
        next.delete(book.id);
        return next;
      });
    }
  };

  return (
    <Container fluid>
      <Breadcrumbs
        mainTitle="Book Library"
        title="Apps"
        path={["Book Library"]}
        Icon={IconBook as any}
      />
      <Row>
        <Col lg={4} xxl={3}>
          <BookLibrarySidebar
            activeTab={activeTab}
            setActiveTab={setActiveTab}
          />
        </Col>
        <Col lg={8} xxl={9}>
          <div className="content-wrapper">
            <div
              id="tab-1"
              className={`tabs-content ${activeTab === "1" ? "active" : ""}`}
            >
              <Row className="mb-4">
                <Col lg={6} className="mb-3 mb-lg-0">
                  <FormGroup>
                    <Label for="searchBooks">Search Books</Label>
                    <InputGroup>
                      <Input
                        id="searchBooks"
                        type="text"
                        placeholder="Search by title, author, or ISBN..."
                        value={searchQuery}
                        onChange={(e) => {
                          setSearchQuery(e.target.value);
                          setCurrentPage(1);
                        }}
                      />
                      <InputGroupText>
                        <IconSearch size={18} />
                      </InputGroupText>
                    </InputGroup>
                  </FormGroup>
                </Col>
              </Row>

              {error && (
                <Alert
                  color="danger"
                  className="mb-4"
                  toggle={() => setError(null)}
                >
                  {error}
                </Alert>
              )}

              {isLoading ? (
                <Row className="justify-content-center">
                  <Col xs={12} className="text-center py-5">
                    <Spinner color="primary" size="lg" />
                    <p className="mt-2 text-muted">Loading books...</p>
                  </Col>
                </Row>
              ) : books.length === 0 ? (
                <Alert color="info" className="text-center py-5">
                  <IconBook size={48} className="mb-3 d-block mx-auto" />
                  <h4>No books found</h4>
                  <p className="mb-0">
                    {searchQuery
                      ? "Try adjusting your search query."
                      : "No books are available in the library yet."}
                  </p>
                </Alert>
              ) : (
                <>
                  <Row className="g-4">
                    {books.map((book) => {
                      const isUnlocking = unlocking.has(book.id);
                      const canRead = Boolean(book.can_access && book.file_url);
                      return (
                        <Col key={book.id} xs={12} sm={6} lg={4} xl={3}>
                          <Card className="h-100 book-card">
                            <div className="book-cover-wrapper position-relative">
                              {book.cover_url ? (
                                <div
                                  className="book-cover position-relative w-100"
                                  style={{ aspectRatio: "2 / 3" }}
                                >
                                  <Image
                                    src={book.cover_url}
                                    alt={book.title}
                                    fill
                                    sizes="(max-width: 768px) 100vw, (max-width: 1200px) 33vw, 25vw"
                                    style={{ objectFit: "cover" }}
                                  />
                                </div>
                              ) : (
                                <div className="book-cover-placeholder d-flex align-items-center justify-content-center bg-light">
                                  <IconFileText size={64} color="#ccc" />
                                </div>
                              )}
                              <span className="badge bg-info position-absolute top-0 end-0 m-2">
                                {book.points} pts
                              </span>
                              {!book.is_active && (
                                <span className="badge bg-secondary position-absolute top-0 start-0 m-2">
                                  Inactive
                                </span>
                              )}
                            </div>
                            <CardBody className="d-flex flex-column">
                              <h5 className="card-title mb-1">{book.title}</h5>
                              <p className="text-muted small mb-2">
                                {book.author || "Unknown Author"}
                              </p>
                              {book.can_access && book.description && (
                                <p className="card-text text-muted small flex-grow-1">
                                  {book.description.substring(0, 100)}
                                  {book.description.length > 100 ? "..." : ""}
                                </p>
                              )}
                              <div className="book-meta small text-muted mb-3">
                                {book.page_count && (
                                  <span className="me-3">
                                    <IconFileText size={14} className="me-1" />
                                    {book.page_count} pages
                                  </span>
                                )}
                                {book.format && (
                                  <span className="badge bg-light text-dark">
                                    {book.format.toUpperCase()}
                                  </span>
                                )}
                              </div>
                              <div className="d-flex gap-2 mt-auto">
                                {canRead ? (
                                  <Button
                                    color="primary"
                                    className="flex-grow-1"
                                    onClick={() => handleRead(book)}
                                  >
                                    Open
                                  </Button>
                                ) : (
                                  <Button
                                    color="outline-primary"
                                    className="flex-grow-1"
                                    onClick={() => handleUnlock(book)}
                                    disabled={isUnlocking}
                                  >
                                    {isUnlocking
                                      ? "Unlocking…"
                                      : `Unlock (${book.points} pts)`}
                                  </Button>
                                )}
                                {book.preview_url && (
                                  <Button
                                    color="outline-secondary"
                                    size="sm"
                                    onClick={() => handlePreview(book)}
                                  >
                                    Preview
                                  </Button>
                                )}
                              </div>
                            </CardBody>
                          </Card>
                        </Col>
                      );
                    })}
                  </Row>

                  {lastPage > 1 && (
                    <nav className="mt-4" aria-label="Books pagination">
                      <ul className="pagination justify-content-center">
                        <li
                          className={`page-item ${currentPage === 1 ? "disabled" : ""}`}
                        >
                          <button
                            className="page-link"
                            onClick={() =>
                              setCurrentPage((p) => Math.max(1, p - 1))
                            }
                            disabled={currentPage === 1}
                          >
                            Previous
                          </button>
                        </li>
                        {Array.from({ length: lastPage }, (_, i) => i + 1).map(
                          (page) => (
                            <li
                              key={page}
                              className={`page-item ${page === currentPage ? "active" : ""}`}
                            >
                              <button
                                className="page-link"
                                onClick={() => setCurrentPage(page)}
                              >
                                {page}
                              </button>
                            </li>
                          )
                        )}
                        <li
                          className={`page-item ${currentPage === lastPage ? "disabled" : ""}`}
                        >
                          <button
                            className="page-link"
                            onClick={() =>
                              setCurrentPage((p) => Math.min(lastPage, p + 1))
                            }
                            disabled={currentPage === lastPage}
                          >
                            Next
                          </button>
                        </li>
                      </ul>
                    </nav>
                  )}
                </>
              )}
            </div>
          </div>
        </Col>
      </Row>
    </Container>
  );
};

export default BookLibraryPage;
