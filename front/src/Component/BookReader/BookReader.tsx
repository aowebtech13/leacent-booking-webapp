"use client";

import React from "react";
import { ReactReader } from "react-book-reader";
import { Spinner } from "reactstrap";
import { IconAlertCircle } from "@tabler/icons-react";

/**
 * Props for the BookReader component.
 *
 * `url` may be a string URL or a `File` object (for local uploads).
 * `location` is a foliate CFI / href used to resume reading.
 * `onLocationChange` receives the foliate `relocate` detail so the parent
 * can persist the current position (e.g. to the backend).
 */
interface BookReaderProps {
  url: string | File;
  location?: string | number | null;
  title?: string;
  showToc?: boolean;
  onLocationChange?: (location: any) => void;
  onTocChange?: (toc: any[]) => void;
  LoadingView?: React.ReactNode;
  ErrorView?: React.ReactNode;
  style?: React.CSSProperties;
  className?: string;
}

/**
 * BookReader wraps `react-book-reader`'s `ReactReader` with sensible defaults
 * for this project: full-height container, loading / error fallback UI, and
 * callbacks for location & TOC changes.
 *
 * react-book-reader injects its own CSS via a JS plugin, so no extra imports
 * are required here.
 */
export const BookReader: React.FC<BookReaderProps> = ({
  url,
  location,
  title,
  showToc = true,
  onLocationChange,
  onTocChange,
  LoadingView,
  ErrorView,
  style,
  className,
}) => {
  const handleTocChange = (toc: any[]) => {
    onTocChange?.(toc);
  };

  const handleLocationChange = (locationDetail: any) => {
    onLocationChange?.(locationDetail);
  };

  const isPdf = typeof url === "string" && url.toLowerCase().includes(".pdf");

  if (isPdf) {
    return (
      <div
        className={className}
        style={{
          height: "100%",
          width: "100%",
          overflow: "hidden",
          background: "#fff",
          ...style,
        }}
      >
        <iframe
          src={`${url}#toolbar=0&navpanes=0&scrollbar=0`}
          title={title ?? "Book Reader"}
          style={{
            width: "100%",
            height: "100%",
            border: "none",
            pointerEvents: "auto",
          }}
          onContextMenu={(e) => e.preventDefault()}
        />
      </div>
    );
  }

  return (
    <div
      className={className}
      style={{
        height: "100%",
        width: "100%",
        overflow: "hidden",
        background: "#fff",
        ...style,
      }}
    >
      <ReactReader
        url={url}
        location={location ?? undefined}
        title={title ?? ""}
        showToc={showToc}
        tocChanged={handleTocChange}
        onUpdateLocation={handleLocationChange}
        LoadingView={
          LoadingView ?? (
            <div
              style={{
                position: "absolute",
                top: "50%",
                left: "10%",
                right: "10%",
                textAlign: "center",
                color: "#999",
              }}
            >
              <Spinner color="primary" />
              <p className="text-muted mt-2 mb-0">Loading book...</p>
            </div>
          )
        }
        ErrorView={
          ErrorView ?? (
            <div
              style={{
                position: "absolute",
                top: "50%",
                left: "10%",
                right: "10%",
                textAlign: "center",
                color: "#c00",
              }}
            >
              <IconAlertCircle size={40} style={{ marginBottom: 8 }} />
              <p className="mb-0">Error loading book</p>
            </div>
          )
        }
      />
    </div>
  );
};
export default BookReader;
