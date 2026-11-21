"use client";

import React, { useCallback, useEffect, useState } from "react";
import {
  Card,
  CardBody,
  Col,
  Container,
  Row,
  Button,
  Spinner,
  Alert,
} from "reactstrap";
import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";
import { getMyBooks, Book } from "@/lib/api/books";
import { IconBook, IconFileText, IconEye } from "@tabler/icons-react";
import { useRouter } from "next/navigation";
import Image from "next/image";
import Link from "next/link";

const UnlockedBooksPage = () => {
  const [books, setBooks] = useState<Book[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const router = useRouter();

  const fetchBooks = useCallback(async () => {
    setIsLoading(true);
    setError(null);
    try {
      const list = await getMyBooks();
      setBooks(list);
    } catch (err: any) {
      setError(err?.message || "Failed to load your books");
    } finally {
      setIsLoading(false);
    }
  }, []);

  useEffect(() => {
    fetchBooks();
  }, [fetchBooks]);

  const handleRead = (book: Book) => {
    if (!book.file_url) {
      setError("This book doesn't have a file available yet. Please contact support.");
      return;
    }
    router.push(`/apps/book-library/read/${book.id}`);
  };

  return (
    <div className="unlocked-books-page">
      <Container fluid>
        <Breadcrumbs
          mainTitle="My Books"
          title="Apps"
          path={["My Books"]}
          Icon={IconBook as any}
        />

        <Row className="mb-4">
          <Col>
            <h4 className="mb-1">Unlocked Books</h4>
            <p className="text-muted mb-0">
              Books you have unlocked with points or a subscription. Your access
              is permanent.
            </p>
          </Col>
        </Row>

        {error && (
          <Alert color="danger" className="mb-4" toggle={() => setError(null)}>
            {error}
          </Alert>
        )}

        {isLoading ? (
          <Row className="justify-content-center">
            <Col xs={12} className="text-center py-5">
              <Spinner color="primary" size="lg" />
              <p className="mt-2 text-muted">Loading your books...</p>
            </Col>
          </Row>
        ) : books.length === 0 ? (
          <Alert color="info" className="text-center py-5">
            <IconBook size={48} className="mb-3 d-block mx-auto" />
            <h4>No unlocked books yet</h4>
            <p className="mb-3">
              You haven&apos;t unlocked any books yet. Browse the library and
              unlock a book with your points to start reading.
            </p>
            <Link href="/apps/book-library" className="btn btn-primary">
              Browse Library
            </Link>
          </Alert>
        ) : (
          <>
            <p className="text-muted mb-4">
              {`${books.length} book${books.length !== 1 ? "s" : ""} unlocked`}
            </p>
            <Row className="g-4">
              {books.map((book) => (
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
                          <IconBook size={64} color="#ccc" />
                        </div>
                      )}
                      <span className="badge bg-info position-absolute top-0 end-0 m-2">
                        {book.points} pts
                      </span>
                      <span className="badge bg-success position-absolute top-0 start-0 m-2">
                        Unlocked
                      </span>
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
                          <span className="me-3 d-inline-flex align-items-center">
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
                        <Button
                          color="primary"
                          className="flex-grow-1"
                          onClick={() => handleRead(book)}
                        >
                          <IconEye size={16} className="me-1" />
                          Read
                        </Button>
                      </div>
                    </CardBody>
                  </Card>
                </Col>
              ))}
            </Row>
          </>
        )}
      </Container>
    </div>
  );
};

export default UnlockedBooksPage;
