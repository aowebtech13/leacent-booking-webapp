"use client";

import React from "react";
import { IconAlertCircle, IconExternalLink } from "@tabler/icons-react";

/**
 * Props for the BookReader component.
 *
 * `url` may be a string URL or a `File` object (for local uploads).
 * `location` is reserved for future reader integrations.
 * `onLocationChange` is reserved for future reader integrations.
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
 * Lightweight in-app reader. Renders PDFs in an iframe and provides an
 * external-open fallback for formats that cannot be rendered natively.
 */
export const BookReader: React.FC<BookReaderProps> = ({
  url,
  title,
  LoadingView,
  ErrorView,
  style,
  className,
}) => {
  const href = typeof url === "string" ? url : URL.createObjectURL(url);
  const lower = href.toLowerCase().split("?")[0];
  const isPdf = lower.endsWith(".pdf");

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
          src={`${href}#toolbar=0&navpanes=0&scrollbar=0`}
          title={title ?? "Book Reader"}
          style={{
            width: "100%",
            height: "100%",
            border: "none",
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
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        background: "#fff",
        padding: "2rem",
        textAlign: "center",
        ...style,
      }}
    >
      {ErrorView ?? (
        <div>
          <IconAlertCircle size={40} style={{ marginBottom: 8, color: "#6c757d" }} />
          <p className="mb-2">This format cannot be previewed in the browser.</p>
          <a
            href={href}
            target="_blank"
            rel="noopener noreferrer"
            className="btn btn-primary btn-sm"
          >
            <IconExternalLink size={16} className="me-1" />
            Open file
          </a>
        </div>
      )}
    </div>
  );
};

export default BookReader;
