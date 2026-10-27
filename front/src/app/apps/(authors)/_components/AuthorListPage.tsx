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
  Input,
  InputGroup,
  InputGroupText,
  FormGroup,
  Label,
} from "reactstrap";
import Image from "next/image";
import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";
import { getPublicAuthors, Author } from "@/lib/api/authors";
import { IconUser, IconSearch, IconBook } from "@tabler/icons-react";
import { useRouter } from "next/navigation";

const AuthorListPage = () => {
  const [authors, setAuthors] = useState<Author[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [searchQuery, setSearchQuery] = useState("");
  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const router = useRouter();

  const fetchAuthors = useCallback(async () => {
    setIsLoading(true);
    setError(null);
    try {
      const query: any = { per_page: 12, page: currentPage };
      if (searchQuery) query.search = searchQuery;
      const res = await getPublicAuthors();
      const list = Array.isArray(res) ? res : [];
      setAuthors(list);
      if (res && (res as any).meta) {
        setCurrentPage((res as any).meta.current_page);
        setLastPage((res as any).meta.last_page);
      }
    } catch (err: any) {
      setError(err?.message || "Failed to load authors");
    } finally {
      setIsLoading(false);
    }
  }, [searchQuery, currentPage]);

  useEffect(() => {
    fetchAuthors();
  }, [fetchAuthors]);

  const handleViewAuthor = (author: Author) => {
    router.push(`/apps/authors/${author.slug || author.id}`);
  };

  return (
    <div className="author-list-page">
      <Container fluid>
        <Breadcrumbs
          mainTitle="Authors"
          title="Apps"
          path={["Authors"]}
          Icon={IconUser as any}
        />

        <Row className="mb-4">
          <Col lg={6} className="mb-3 mb-lg-0">
            <FormGroup>
              <Label for="searchAuthors">Search Authors</Label>
              <InputGroup>
                <Input
                  id="searchAuthors"
                  type="text"
                  placeholder="Search by author name..."
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
              <p className="mt-2 text-muted">Loading authors...</p>
            </Col>
          </Row>
        ) : authors.length === 0 ? (
          <Alert color="info" className="text-center py-5">
            <IconUser size={48} className="mb-3 d-block" />
            <h4>No authors found</h4>
            <p className="mb-0">
              {searchQuery
                ? "Try adjusting your search query."
                : "No authors are available yet."}
            </p>
          </Alert>
        ) : (
          <>
            <Row className="g-4">
              {authors.map((author) => (
                <Col key={author.id} xs={12} sm={6} lg={4} xl={3}>
                  <Card className="h-100 author-card">
                    <CardBody className="d-flex flex-column text-center">
                      {author.avatar ? (
                        <Image
                          src={author.avatar}
                          alt={author.name}
                          className="author-avatar img-fluid mx-auto mb-3 rounded-circle"
                          width={120}
                          height={120}
                          priority
                          sizes="120px"
                        />
                      ) : (
                        <div className="author-avatar-placeholder d-flex align-items-center justify-content-center bg-light mx-auto mb-3 rounded-circle">
                          <IconUser size={64} color="#ccc" />
                        </div>
                      )}
                      <h5 className="card-title mb-1">{author.name}</h5>
                      {author.bio && (
                        <p className="card-text text-muted small flex-grow-1">
                          {author.bio.substring(0, 120)}
                          {author.bio.length > 120 ? "..." : ""}
                        </p>
                      )}
                      <div className="author-meta small text-muted mb-3">
                        {author.books_count && (
                          <span className="me-3">
                            <IconBook size={14} className="me-1" />
                            {`${author.books_count} book${
                              author.books_count !== 1 ? "s" : ""
                            }`}
                          </span>
                        )}
                      </div>
                      <Button
                        color="primary"
                        className="w-100"
                        onClick={() => handleViewAuthor(author)}
                      >
                        View Author
                      </Button>
                    </CardBody>
                  </Card>
                </Col>
              ))}
            </Row>

            {lastPage > 1 && (
              <nav className="mt-4" aria-label="Authors pagination">
                <ul className="pagination justify-content-center">
                  <li
                    className={`page-item ${currentPage === 1 ? "disabled" : ""}`}
                  >
                    <button
                      className="page-link"
                      onClick={() => {
                        setCurrentPage(currentPage - 1);
                        fetchAuthors();
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
                            fetchAuthors();
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
                        fetchAuthors();
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

export default AuthorListPage;
