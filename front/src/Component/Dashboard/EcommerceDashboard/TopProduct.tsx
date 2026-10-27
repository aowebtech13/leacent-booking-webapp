import React, { useState, useEffect } from "react";
import Image from "next/image";
import { Badge, Card, CardBody, Col, Row, Table } from "reactstrap";
import { Language, StarSolid } from "iconoir-react";
import { getBooks, Book, Author } from "@/lib/api/books";
import { getPublicAuthors } from "@/lib/api/authors";

const authorCardClasses = [
  "country-card-warning",
  "bg-primary-300",
  "country-card-danger",
  "country-card-info",
  "country-card-danger",
  "country-card-warning",
];

const authorAvatar = (author: Author) => {
  if (!author.avatar) return "/images/avatar/1.png";
  if (/^https?:\/\//.test(author.avatar)) return author.avatar;
  const base =
    process.env.NEXT_PUBLIC_API_BASE_URL || "https://leacentbooks-enterpise.lexicron.org/api";
  return `${base.replace(/\/api$/, "")}/storage/${author.avatar}`;
};

const TopProduct = () => {
  const [topProducts, setTopProducts] = useState<Book[]>([]);
  const [topProductsLoading, setTopProductsLoading] = useState(true);
  const [topProductsError, setTopProductsError] = useState<string | null>(null);
  const [authors, setAuthors] = useState<Author[]>([]);
  const [authorsLoading, setAuthorsLoading] = useState(true);

  useEffect(() => {
    let cancelled = false;
    const fetchTopProducts = async () => {
      setTopProductsLoading(true);
      setTopProductsError(null);
      try {
        const res = await getBooks({
          sort: "read_count",
          direction: "desc",
          per_page: 4,
        });
        // The API response wraps a paginator: res.data may be the paginator
        // object { data: Book[] } or, when unwrapped, the array itself.
        const payload = (res.data as any) ?? [];
        const books = Array.isArray(payload) ? payload : (payload.data ?? []);
        if (!cancelled) setTopProducts(books);
      } catch (err: any) {
        if (!cancelled)
          setTopProductsError(err?.message || "Failed to load top products");
      } finally {
        if (!cancelled) setTopProductsLoading(false);
      }
    };
    fetchTopProducts();
    return () => {
      cancelled = true;
    };
  }, []);

  useEffect(() => {
    let cancelled = false;
    const fetchAuthors = async () => {
      setAuthorsLoading(true);
      try {
        const data = await getPublicAuthors();
        if (!cancelled) setAuthors(data ?? []);
      } catch {
        if (!cancelled) setAuthors([]);
      } finally {
        if (!cancelled) setAuthorsLoading(false);
      }
    };
    fetchAuthors();
    return () => {
      cancelled = true;
    };
  }, []);

  const authorsData = authors
    .slice()
    .sort((a, b) => (b.books_count ?? 0) - (a.books_count ?? 0))
    .slice(0, authorCardClasses.length)
    .map((author, index) => ({
      id: author.id,
      name: author.name,
      books: author.books_count ?? 0,
      avatar: authorAvatar(author),
      cardClass: authorCardClasses[index],
      isOnline: index === 1,
    }));

  return (
    <>
      <Col lg="6" xxl="5">
        <div className="p-3">
          <h5>Top Books List</h5>
        </div>
        <Card>
          <CardBody className="px-0">
            <div className="table-responsive app-scroll">
              <Table className="align-middle top-products-table mb-0">
                <thead>
                  <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Units Sold</th>
                    <th scope="col">Sales</th>
                    <th scope="col">Rating</th>
                  </tr>
                </thead>
                <tbody>
                  {topProductsLoading ? (
                    <tr>
                      <td colSpan={4} className="text-center text-muted py-4">
                        Loading top products…
                      </td>
                    </tr>
                  ) : topProductsError ? (
                    <tr>
                      <td colSpan={4} className="text-center text-danger py-4">
                        {topProductsError}
                      </td>
                    </tr>
                  ) : topProducts.length === 0 ? (
                    <tr>
                      <td colSpan={4} className="text-center text-muted py-4">
                        No top products available.
                      </td>
                    </tr>
                  ) : (
                    topProducts.map((product, index) => (
                      <tr key={product.id ?? index}>
                        <td>
                          <div className="d-flex align-items-center">
                            <h6
                              className="mb-0 text-truncate"
                              style={{ maxWidth: "150px" }}
                            >
                              {product.title}
                            </h6>
                          </div>
                        </td>
                        <td>
                          <Badge
                            color={
                              product.read_count > 200
                                ? "light-success"
                                : product.read_count > 150
                                  ? "light-primary"
                                  : "light-danger"
                            }
                            className="f-s-12 f-w-700"
                          >
                            {product.read_count}
                          </Badge>
                        </td>
                        <td className="f-w-600 text-dark">
                          ₦{Number(product.price ?? 0).toLocaleString()}
                        </td>
                        <td className="text-warning-dark f-w-600">
                          <StarSolid
                            height={16}
                            width={16}
                            className="text-warning me-1"
                          />
                          {product.rating ?? 0}
                        </td>
                      </tr>
                    ))
                  )}
                </tbody>
              </Table>
            </div>
          </CardBody>
        </Card>
      </Col>
      <Col lg="6" xxl="7">
        <div className="p-3">
          <h5>Books By Authors</h5>
        </div>
        <Row>
          {authorsLoading ? (
            <Col xs="12" className="text-muted text-center py-4">
              Loading authors…
            </Col>
          ) : authorsData.length === 0 ? (
            <Col xs="12" className="text-muted text-center py-4">
              No authors available.
            </Col>
          ) : (
            authorsData.map((author) => (
              <Col key={author.id} xs="6" sm="4" md="3" lg="3" xl="3" xxl="3">
                <Card className={author.cardClass}>
                  <CardBody>
                    <Image
                      src={author.avatar}
                      className="w-30 h-30 b-r-20"
                      alt={author.name}
                      width={30}
                      height={30}
                      sizes="30px"
                      unoptimized
                    />
                    <div className="mt-6">
                      <h6 className="mb-0 text-truncate">{author.name}</h6>
                      <p className="f-w-600 mb-0 text-truncate">
                        {author.books} {author.books === 1 ? "Book" : "Books"}
                      </p>
                    </div>
                    <Language
                      height={70}
                      width={120}
                      className="icon-bg text-white"
                    />
                    {author.isOnline && (
                      <span
                        className={`position-absolute top-0 end-0 pa-6 bg-success b-2-white border-light rounded-circle animate__animated animate__heartBeat animate__infinite animate__fast`}
                      ></span>
                    )}
                  </CardBody>
                </Card>
              </Col>
            ))
          )}
        </Row>
      </Col>
    </>
  );
};

export default TopProduct;
