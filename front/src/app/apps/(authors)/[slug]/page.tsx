import React from "react";
import { getPublicAuthor } from "@/lib/api/authors";
import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";
import { IconBook, IconUser } from "@tabler/icons-react";
import Link from "next/link";
import Image from "next/image";
import type { Metadata } from "next";

interface AuthorDetailResponse {
  id: number;
  name: string;
  slug: string;
  bio: string | null;
  email: string | null;
  phone: string | null;
  website: string | null;
  avatar: string | null;
  is_active: boolean;
  books_count?: number;
  books?: Array<{
    id: number;
    title: string;
    slug: string;
    description: string | null;
    author: string | null;
    publisher: string | null;
    language: string | null;
    category: string | null;
    publication_year: number | null;
    page_count: number | null;
    format: string | null;
    cover_image_path: string | null;
    preview_path: string | null;
    is_premium: boolean;
    points: number;
    is_active: boolean;
    is_featured: boolean;
    read_count: number;
    download_count: number;
    rating: number | string | null;
    reviews_count: number;
    tags: string[] | null;
    cover_url: string | null;
    preview_url: string | null;
    file_url: string | null;
  }>;
}

export async function generateMetadata({
  params,
}: {
  params: Promise<{ slug: string }>;
}): Promise<Metadata> {
  const { slug } = await params;
  let author: AuthorDetailResponse | null = null;
  try {
    author = (await getPublicAuthor(slug)) as AuthorDetailResponse;
  } catch {
    // fall back to slug-based title
  }

  return {
    title: author
      ? `${author.name} - Author - Business Labs`
      : "Author - Business Labs - Books & Movies",
    description: author?.bio
      ? author.bio.substring(0, 160)
      : "Browse books by this author.",
    openGraph: {
      title: author
        ? `${author.name} - Author - Business Labs`
        : "Author - Business Labs - Books & Movies",
      description: author?.bio
        ? author.bio.substring(0, 160)
        : "Browse books by this author.",
      url: `https://businesslab.leacent.org/apps/authors/${slug}`,
      siteName: "BUSINESS LAB - BOOKS & MOVIES",
      locale: "en_US",
      type: "website",
    },
  };
}

export default async function AuthorDetailPage({
  params,
}: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await params;
  let author: AuthorDetailResponse | null = null;
  let error: string | null = null;

  try {
    author = (await getPublicAuthor(slug)) as AuthorDetailResponse;
  } catch (err: any) {
    error = err?.message || "Failed to load author.";
  }

  const books = author?.books ?? [];

  return (
    <div className="author-detail-page">
      <div className="container-fluid">
        {error ? (
          <div className="row justify-content-center mt-5">
            <div className="col-md-8 text-center">
              <div className="alert alert-danger">
                <IconUser size={48} className="mb-3 d-block mx-auto" />
                <h4>Author not found</h4>
                <p className="mb-0">{error}</p>
                <Link
                  href="/apps/authors"
                  className="btn btn-primary mt-3"
                >
                  Back to Authors
                </Link>
              </div>
            </div>
          </div>
        ) : (
          <>
            <Breadcrumbs
              mainTitle="Author"
              title={author?.name ?? ""}
              path={["Authors", author?.slug ?? ""]}
              Icon={IconUser as any}
            />

            <div className="row mb-4">
              <div className="col-lg-4 mb-4">
                <div className="card h-100 shadow-sm">
                  <div className="card-body text-center">
                    {author?.avatar ? (
                      <Image
                        src={author.avatar}
                        alt={author.name}
                        className="author-avatar img-fluid mx-auto mb-3 rounded-circle"
                        width={160}
                        height={160}
                        priority
                        sizes="160px"
                      />
                    ) : (
                      <div className="author-avatar-placeholder d-flex align-items-center justify-content-center bg-light mx-auto mb-3 rounded-circle">
                        <IconUser size={80} color="#aaa" />
                      </div>
                    )}
                    <h2 className="card-title mb-2">{author?.name}</h2>
                    {author?.bio && (
                      <p className="card-text text-muted small mb-3">
                        {author.bio}
                      </p>
                    )}
                    <div className="author-meta small text-muted mb-3">
                      {author?.books_count && (
                        <span className="me-3 d-inline-block">
                          <IconBook size={14} className="me-1" />
                          {`${author.books_count} book${
                            author.books_count !== 1 ? "s" : ""
                          }`}
                        </span>
                      )}
                      {author?.website && (
                        <a
                          href={author.website}
                          target="_blank"
                          rel="noopener noreferrer"
                          className="text-decoration-underline"
                        >
                          Website
                        </a>
                      )}
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-lg-8">
                <h4 className="mb-3">Books by {author?.name}</h4>
                {books.length === 0 ? (
                  <div className="alert alert-info text-center py-5">
                    <IconBook size={48} className="mb-3 d-block mx-auto" />
                    <p className="mb-0">No books available yet.</p>
                  </div>
                ) : (
                  <div className="row g-4">
                    {books.map((book) => (
                      <div
                        key={book.id}
                        className="col-sm-6 col-lg-4"
                      >
                        <div className="card h-100 shadow-sm book-card">
                          <div className="book-cover-wrapper position-relative">
                            {book.cover_url ? (
                              <Image
                                src={book.cover_url}
                                alt={book.title}
                                fill
                                className="book-cover"
                                style={{ objectFit: "cover", aspectRatio: "2 / 3" }}
                                sizes="(max-width: 768px) 100vw, (max-width: 1200px) 33vw, 25vw"
                                priority
                              />
                            ) : (
                              <div className="book-cover-placeholder d-flex align-items-center justify-content-center bg-light h-100">
                                <IconBook size={64} color="#ccc" />
                              </div>
                            )}
                            <span className="badge bg-info position-absolute top-0 end-0 m-2">
                              {book.points} pts
                            </span>
                          </div>
                          <div className="card-body d-flex flex-column">
                            <h5 className="card-title mb-1">{book.title}</h5>
                            {book.description && (
                              <p className="card-text text-muted small flex-grow-1">
                                {book.description.substring(0, 120)}
                                {book.description.length > 120 ? "..." : ""}
                              </p>
                            )}
                            <div className="book-meta small text-muted mb-3">
                              {book.page_count && (
                                <span className="me-3">
                                  {book.page_count} pages
                                </span>
                              )}
                              {book.publication_year && (
                                <span className="me-3">
                                  {book.publication_year}
                                </span>
                              )}
                            </div>
                            <Link
                              href={`/apps/book-library/read/${book.id}`}
                              className="btn btn-primary w-100"
                            >
                              Read Book
                            </Link>
                          </div>
                        </div>
                      </div>
                    ))}
                  </div>
                )}
              </div>
            </div>
          </>
        )}
      </div>
    </div>
  );
}
