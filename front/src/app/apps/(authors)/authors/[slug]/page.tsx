import React from "react";
import { getPublicAuthor } from "@/lib/api/authors";
import { avatarUrl } from "@/lib/api/client";
import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";
import {
  IconBook,
  IconUser,
  IconMail,
  IconPhone,
  IconWorld,
  IconCalendar,
  IconStar,
  IconEye,
  IconFileText,
  IconBuilding,
  IconTag,
} from "@tabler/icons-react";
import Link from "next/link";
import Image from "next/image";
import { notFound } from "next/navigation";
import type { Metadata } from "next";

export const dynamic = "force-dynamic";

interface AuthorBook {
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
}

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
  created_at?: string | null;
  updated_at?: string | null;
  books_count?: number;
  books?: AuthorBook[];
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
    notFound();
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

const formatDate = (value?: string | null) => {
  if (!value) return null;
  const date = new Date(value);
  if (Number.isNaN(date.getTime())) return null;
  return date.toLocaleDateString("en-US", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });
};

export default async function AuthorDetailPage({
  params,
}: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await params;
  let author: AuthorDetailResponse | null = null;
  let error: string | null = null;
  let authorNotFound = false;

  try {
    author = (await getPublicAuthor(slug)) as AuthorDetailResponse;
  } catch (err: any) {
    error = err?.message || "Failed to load author.";
    authorNotFound = true;
  }

  if (authorNotFound) {
    notFound();
  }

  const books = author?.books ?? [];
  const booksCount = author?.books_count ?? books.length;
  const joinedDate = formatDate(author?.created_at);
  const avatarSrc = avatarUrl(author?.avatar);

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
                <Link href="/apps/authors" className="btn btn-primary mt-3">
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
                    {avatarSrc ? (
                      <Image
                        src={avatarSrc}
                        alt={author!.name}
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
                    <h2 className="card-title mb-1">{author?.name}</h2>
                    {author?.slug && (
                      <p className="text-muted small mb-3">@{author.slug}</p>
                    )}
                    {author?.bio && (
                      <p className="card-text text-muted small mb-3">
                        {author.bio}
                      </p>
                    )}

                    <ul className="list-unstyled text-start author-info-list mb-3">
                      <li className="mb-2 d-flex align-items-center">
                        <IconBook size={16} className="me-2 text-primary" />
                        <span>
                          {`${booksCount} book${booksCount !== 1 ? "s" : ""}`}
                        </span>
                      </li>
                      {author?.email && (
                        <li className="mb-2 d-flex align-items-center">
                          <IconMail size={16} className="me-2 text-primary" />
                          <a href={`mailto:${author.email}`}>
                            {author.email}
                          </a>
                        </li>
                      )}
                      {author?.phone && (
                        <li className="mb-2 d-flex align-items-center">
                          <IconPhone size={16} className="me-2 text-primary" />
                          <a href={`tel:${author.phone}`}>{author.phone}</a>
                        </li>
                      )}
                      {author?.website && (
                        <li className="mb-2 d-flex align-items-center">
                          <IconWorld size={16} className="me-2 text-primary" />
                          <a
                            href={author.website}
                            target="_blank"
                            rel="noopener noreferrer"
                          >
                            {author.website}
                          </a>
                        </li>
                      )}
                      {joinedDate && (
                        <li className="d-flex align-items-center">
                          <IconCalendar
                            size={16}
                            className="me-2 text-primary"
                          />
                          <span>Joined {joinedDate}</span>
                        </li>
                      )}
                    </ul>

                    <Link
                      href="/apps/authors"
                      className="btn btn-outline-primary w-100"
                    >
                      Back to Authors
                    </Link>
                  </div>
                </div>
              </div>

              <div className="col-lg-8">
                <h4 className="mb-3">
                  {`Books by ${author?.name ?? "this author"}`}
                  {booksCount > 0 && (
                    <span className="badge bg-primary ms-2">{booksCount}</span>
                  )}
                </h4>
                {books.length === 0 ? (
                  <div className="alert alert-info text-center py-5">
                    <IconBook size={48} className="mb-3 d-block mx-auto" />
                    <h5>No books available yet</h5>
                    <p className="mb-0 text-muted">
                      This author has not published any books yet. Please check
                      back later.
                    </p>
                  </div>
                ) : (
                  <div className="row g-4">
                    {books.map((book) => (
                      <div key={book.id} className="col-sm-6 col-xl-4">
                        <div className="card h-100 shadow-sm book-card">
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
                                  className="book-cover"
                                  style={{ objectFit: "cover" }}
                                  sizes="(max-width: 768px) 100vw, (max-width: 1200px) 33vw, 25vw"
                                />
                              </div>
                            ) : (
                              <div className="book-cover-placeholder d-flex align-items-center justify-content-center bg-light h-100">
                                <IconBook size={64} color="#ccc" />
                              </div>
                            )}
                            <span className="badge bg-info position-absolute top-0 end-0 m-2">
                              {book.points} pts
                            </span>
                            {book.is_premium && (
                              <span className="badge bg-warning text-dark position-absolute top-0 start-0 m-2">
                                Premium
                              </span>
                            )}
                          </div>
                          <div className="card-body d-flex flex-column">
                            <h5 className="card-title mb-1">{book.title}</h5>
                            {book.description && (
                              <p className="card-text text-muted small mb-2">
                                {book.description.substring(0, 120)}
                                {book.description.length > 120 ? "..." : ""}
                              </p>
                            )}
                            <div className="book-meta small text-muted mb-2">
                              {book.category && (
                                <span className="me-3 d-inline-flex align-items-center">
                                  <IconTag size={14} className="me-1" />
                                  {book.category}
                                </span>
                              )}
                              {book.language && (
                                <span className="me-3">{book.language}</span>
                              )}
                              {book.format && (
                                <span className="badge bg-light text-dark me-1">
                                  {book.format.toUpperCase()}
                                </span>
                              )}
                            </div>
                            <div className="book-meta small text-muted mb-2">
                              {book.publisher && (
                                <span className="me-3 d-inline-flex align-items-center">
                                  <IconBuilding size={14} className="me-1" />
                                  {book.publisher}
                                </span>
                              )}
                              {book.publication_year && (
                                <span className="me-3">
                                  {book.publication_year}
                                </span>
                              )}
                              {book.page_count && (
                                <span className="me-3 d-inline-flex align-items-center">
                                  <IconFileText size={14} className="me-1" />
                                  {book.page_count} pages
                                </span>
                              )}
                            </div>
                            <div className="book-meta small text-muted mb-3">
                              {book.rating !== null &&
                                book.rating !== undefined && (
                                  <span className="me-3 d-inline-flex align-items-center">
                                    <IconStar
                                      size={14}
                                      className="me-1 text-warning"
                                    />
                                    {book.rating}
                                    {book.reviews_count > 0 &&
                                      ` (${book.reviews_count})`}
                                  </span>
                                )}
                              <span className="d-inline-flex align-items-center">
                                <IconEye size={14} className="me-1" />
                                {book.read_count}
                              </span>
                            </div>
                            <Link
                              href={`/apps/book-library/read/${book.id}`}
                              className="btn btn-primary w-100 mt-auto"
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