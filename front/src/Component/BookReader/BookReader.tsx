"use client";

import React, { useEffect, useState } from "react";
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
  const [hasError, setHasError] = useState(false);
  const [errorMessage] = useState<string>(
    "Failed to load book. The format may not be supported or the file is unavailable."
  );

  // Reset error state when url changes.
  useEffect(() => {
    setHasError(false);
  }, [url]);

  const handleTocChange = (toc: any[]) => {
    onTocChange?.(toc);
  };

  const handleLocationChange = (locationDetail: any) => {
    onLocationChange?.(locationDetail);
  };

  if (hasError) {
    return (
      <div
        className={className}
        style={{
          height: "100%",
          width: "100%",
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
          background: "#fafafa",
          ...style,
        }}
      >
        <div style={{ textAlign: "center", maxWidth: 420, padding: 24 }}>
          <IconAlertCircle size={56} color="red" style={{ marginBottom: 16 }} />
          <h5 className="mb-2">Unable to load book</h5>
          <p className="text-muted mb-0">{errorMessage}</p>
        </div>
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
