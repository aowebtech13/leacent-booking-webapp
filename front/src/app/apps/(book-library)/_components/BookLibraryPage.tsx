"use client";

import React, { useEffect, useState } from "react";
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
import { getBooks, Book } from "@/lib/api/books";
import { IconBook, IconSearch, IconFileText } from "@tabler/icons-react";
import { useRouter } from "next/navigation";

const BookLibraryPage = () => {
  const [books, setBooks] = useState<Book[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [searchQuery, setSearchQuery] = useState("");
  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const router = useRouter();

  const fetchBooks = async () => {
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
        setCurrentPage(meta.current_page);
        setLastPage(meta.last_page);
      } else if ((payload as any).current_page) {
        setCurrentPage((payload as any).current_page);
        setLastPage((payload as any).last_page);
      }
    } catch (err: any) {
      setError(err?.message || "Failed to load books");
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    fetchBooks();
  }, [searchQuery]);

  const handleRead = (book: Book) => {
    if (!book.file_url && !book.can_access) {
      setError("This book is not available for reading yet.");
      return;
    }
    router.push(`/apps/book-library/read/${book.id}`);
  };

  const handlePreview = (book: Book) => {
    if (book.preview_url) {
      window.open(book.preview_url, "_blank");
    }
  };

  return (
    <div className="book-library-page">
      <Container fluid>
        <Breadcrumbs
          mainTitle="Book Library"
          title="Apps"
          path={["Book Library"]}
          Icon={IconBook as any}
        />

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
                  onChange={(e) => setSearchQuery(e.target.value)}
                />
                <InputGroupText>
                  <IconSearch size={18} />
                </InputGroupText>
              </InputGroup>
            </FormGroup>
          </Col>
        </Row>

        {error && (
          <Alert color="danger" className="mb-4">
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
            <IconBook size={48} className="mb-3 d-block" />
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
              {books.map((book) => (
                <Col key={book.id} xs={12} sm={6} lg={4} xl={3}>
                  <Card className="h-100 book-card">
                    <div className="book-cover-wrapper position-relative">
                      {book.cover_url ? (
                        <img
                          src={book.cover_url}
                          alt={book.title}
                          className="book-cover img-fluid w-100"
                        />
                      ) : (
                        <div className="book-cover-placeholder d-flex align-items-center justify-content-center bg-light">
                          <IconFileText size={64} color="#ccc" />
                        </div>
                      )}
                      {book.is_premium && (
                        <span className="badge bg-warning position-absolute top-0 end-0 m-2">
                          Premium
                        </span>
                      )}
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
                      {book.description && (
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
                        {book.can_access && book.file_url ? (
                          <Button
                            color="primary"
                            className="flex-grow-1"
                            onClick={() => handleRead(book)}
                          >
                            Read Now
                          </Button>
                        ) : book.is_premium ? (
                          <Button
                            color="outline-primary"
                            className="flex-grow-1"
                            disabled
                          >
                            Premium Only
                          </Button>
                        ) : (
                          <Button
                            color="outline-secondary"
                            className="flex-grow-1"
                            disabled
                          >
                            Not Available
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
              ))}
            </Row>

            {lastPage > 1 && (
              <nav className="mt-4" aria-label="Books pagination">
                <ul className="pagination justify-content-center">
                  <li
                    className={`page-item ${currentPage === 1 ? "disabled" : ""}`}
                  >
                    <button
                      className="page-link"
                      onClick={() => {
                        setCurrentPage(currentPage - 1);
                        fetchBooks();
                      }}
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
                          onClick={() => {
                            setCurrentPage(page);
                            fetchBooks();
                          }}
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
                      onClick={() => {
                        setCurrentPage(currentPage + 1);
                        fetchBooks();
                      }}
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
      </Container>
    </div>
  );
};

export default BookLibraryPage;
