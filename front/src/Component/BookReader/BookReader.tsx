"use client";

import React, { useState, useCallback } from "react";
import { Document, Page, pdfjs } from "react-pdf";
import { IconAlertCircle, IconExternalLink, IconChevronLeft, IconChevronRight, IconZoomIn, IconZoomOut, IconRotate, IconDownload, IconSearch } from "@tabler/icons-react";

pdfjs.GlobalWorkerOptions.workerSrc = `//cdnjs.cloudflare.com/ajax/libs/pdf.js/${pdfjs.version}/pdf.worker.min.js`;

interface BookReaderProps {
  url: string | File;
  isPdf?: boolean;
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

export const BookReader: React.FC<BookReaderProps> = ({
  url,
  title,
  ErrorView,
  style,
  className,
  isPdf,
  onLocationChange,
  onTocChange,
}) => {
  const href = typeof url === "string" ? url : URL.createObjectURL(url);
  const lower = href.toLowerCase().split("?")[0] ?? "";
  const pdf = isPdf ?? lower.endsWith(".pdf");

  const [numPages, setNumPages] = useState<number | null>(null);
  const [pageNumber, setPageNumber] = useState(1);
  const [scale, setScale] = useState(1.2);
  const [rotation, setRotation] = useState(0);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [outline, setOutline] = useState<any[]>([]);
  const [showOutline, setShowOutline] = useState(false);
  const [searchQuery, setSearchQuery] = useState("");
  const [searchResults, setSearchResults] = useState<any[]>([]);
  const [currentSearchIndex, setCurrentSearchIndex] = useState(0);

  const onDocumentLoadSuccess = useCallback((doc: any) => {
    setNumPages(doc.numPages);
    setIsLoading(false);
    if (doc.fingerprints) {
      doc.getOutline().then((outline: any[]) => {
        if (outline && outline.length > 0) {
          setOutline(outline);
          onTocChange?.(outline);
        }
      });
    }
  }, [onTocChange]);

  const onLoadError = useCallback((err: any) => {
    setError(err.message || "Failed to load PDF");
    setIsLoading(false);
  }, []);

  const onPageChange = useCallback((page: number) => {
    setPageNumber(page);
    onLocationChange?.({ page, cfi: page });
  }, [onLocationChange]);

  const handleZoomIn = () => setScale((prev) => Math.min(prev + 0.2, 3));
  const handleZoomOut = () => setScale((prev) => Math.max(prev - 0.2, 0.5));
  const handleRotate = () => setRotation((prev) => (prev + 90) % 360);
  const handleDownload = () => {
    const a = document.createElement("a");
    a.href = href;
    a.download = title || "book.pdf";
    a.click();
  };

  const handleSearch = async (query: string) => {
    if (!query.trim()) {
      setSearchResults([]);
      setCurrentSearchIndex(0);
      return;
    }
    setSearchQuery(query);
    try {
      const doc = await pdfjs.getDocument({ url: href }).promise;
      const results: any[] = [];
      for (let i = 1; i <= doc.numPages; i++) {
        const page = await doc.getPage(i);
        const textContent = await page.getTextContent();
        const text = textContent.items.map((item: any) => item.str).join(" ");
        if (text.toLowerCase().includes(query.toLowerCase())) {
          results.push({ page: i, text: text.substring(0, 200) });
        }
      }
      setSearchResults(results);
      setCurrentSearchIndex(0);
      if (results.length > 0) {
        onPageChange(results[0].page);
      }
    } catch (err) {
      console.error("Search failed:", err);
    }
  };

  const goToSearchResult = (index: number) => {
    if (searchResults[index]) {
      setCurrentSearchIndex(index);
      onPageChange(searchResults[index].page);
    }
  };

  if (!pdf) {
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
            <IconAlertCircle
              size={40}
              style={{ marginBottom: 8, color: "#6c757d" }}
            />
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
  }

  if (isLoading) {
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
          ...style,
        }}
      >
        <div className="text-center">
          <div className="spinner-border text-primary" role="status">
            <span className="visually-hidden">Loading PDF...</span>
          </div>
          <p className="mt-2 text-muted">Loading document...</p>
        </div>
      </div>
    );
  }

  if (error) {
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
            <IconAlertCircle
              size={40}
              style={{ marginBottom: 8, color: "#dc3545" }}
            />
            <p className="mb-2">Failed to load PDF</p>
            <p className="text-muted small mb-3">{error}</p>
            <a
              href={href}
              target="_blank"
              rel="noopener noreferrer"
              className="btn btn-primary btn-sm"
            >
              <IconExternalLink size={16} className="me-1" />
              Open in new tab
            </a>
          </div>
        )}
      </div>
    );
  }

  const sidebarWidth = showOutline || searchQuery ? 280 : 0;

  return (
    <div
      className={className}
      style={{
        height: "100%",
        width: "100%",
        display: "flex",
        background: "#f5f5f5",
        ...style,
      }}
    >
      <aside
        style={{
          width: sidebarWidth,
          minWidth: sidebarWidth,
          height: "100%",
          background: "#fff",
          borderRight: "1px solid #dee2e6",
          display: "flex",
          flexDirection: "column",
          overflow: "hidden",
          transition: "width 0.2s ease",
        }}
      >
        <div className="p-3 border-bottom d-flex justify-content-between align-items-center">
          <h6 className="mb-0 fw-medium">Navigation</h6>
          <button
            className="btn btn-sm btn-outline-secondary"
            onClick={() => setShowOutline(false)}
            onMouseDown={(e) => e.preventDefault()}
          >
            <IconChevronLeft size={16} />
          </button>
        </div>
        <div className="p-2 border-bottom">
          <input
            type="text"
            className="form-control form-control-sm"
            placeholder="Search in document..."
            value={searchQuery}
            onChange={(e) => handleSearch(e.target.value)}
            onKeyDown={(e) => e.key === "Enter" && searchResults.length > 0 && goToSearchResult(0)}
          />
        </div>
        <div className="flex-grow-1 overflow-auto p-2">
          {searchQuery && searchResults.length > 0 && (
            <div className="mb-3">
              <div className="d-flex justify-content-between align-items-center mb-2">
                <small className="text-muted fw-medium">
                  {searchResults.length} result(s) for "{searchQuery}"
                </small>
                <div className="btn-group btn-group-sm">
                  <button
                    className="btn btn-outline-secondary"
                    onClick={() => goToSearchResult(Math.max(0, currentSearchIndex - 1))}
                    disabled={currentSearchIndex === 0}
                  >
                    <IconChevronLeft size={14} />
                  </button>
                  <span className="btn btn-outline-secondary disabled px-2">
                    {currentSearchIndex + 1} / {searchResults.length}
                  </span>
                  <button
                    className="btn btn-outline-secondary"
                    onClick={() => goToSearchResult(Math.min(searchResults.length - 1, currentSearchIndex + 1))}
                    disabled={currentSearchIndex === searchResults.length - 1}
                  >
                    <IconChevronRight size={14} />
                  </button>
                </div>
              </div>
              <div className="small" style={{ maxHeight: "200px", overflow: "auto" }}>
                {searchResults.map((result, idx) => (
                  <button
                    key={result.page}
                    className={`btn btn-sm w-100 text-start p-2 mb-1 ${idx === currentSearchIndex ? "btn-primary" : "btn-outline-secondary"}`}
                    onClick={() => goToSearchResult(idx)}
                    style={{ whiteSpace: "normal" }}
                  >
                    <div className="fw-medium">Page {result.page}</div>
                    <div className="text-truncate small">{result.text}...</div>
                  </button>
                ))}
              </div>
            </div>
          )}
          {outline.length > 0 && !searchQuery && (
            <ul className="list-unstyled mb-0">
              {outline.map((item, idx) => (
                <li key={idx} className="mb-1">
                  <button
                    className="btn btn-sm w-100 text-start p-2 btn-outline-secondary"
                    onClick={() => item.dest && onPageChange(item.dest[0])}
                    style={{ whiteSpace: "normal" }}
                  >
                    {item.title}
                  </button>
                  {item.items && item.items.length > 0 && (
                    <ul className="list-unstyled ms-3 mt-1">
                      {item.items.map((sub: any, sIdx: number) => (
                        <li key={sIdx} className="mb-1">
                          <button
                            className="btn btn-sm w-100 text-start p-1 btn-outline-secondary"
                            onClick={() => sub.dest && onPageChange(sub.dest[0])}
                            style={{ whiteSpace: "normal", fontSize: "0.8rem" }}
                          >
                            {sub.title}
                          </button>
                        </li>
                      ))}
                    </ul>
                  )}
                </li>
              ))}
            </ul>
          )}
          {!searchQuery && outline.length === 0 && (
            <p className="text-center text-muted small mt-4">No table of contents available</p>
          )}
        </div>
      </aside>

      <div style={{ flex: 1, display: "flex", flexDirection: "column", height: "100%" }}>
        <nav className="navbar navbar-light bg-white border-bottom px-3 py-2" style={{ zIndex: 10, flexShrink: 0 }}>
          <div className="d-flex align-items-center w-100">
            <button
              className="btn btn-sm btn-outline-secondary me-2"
              onClick={() => setShowOutline(!showOutline)}
              style={{ minWidth: "40px" }}
            >
              <IconSearch size={18} />
            </button>
            <div className="flex-grow-1 text-center">
              <h6 className="mb-0 fw-medium" style={{ maxWidth: "400px", whiteSpace: "nowrap", overflow: "hidden", textOverflow: "ellipsis" }}>
                {title || "Document"}
              </h6>
            </div>
            <div className="d-flex align-items-center gap-2">
              <div className="btn-group btn-group-sm" role="group">
                <button className="btn btn-outline-secondary" onClick={handleZoomOut} title="Zoom out">
                  <IconZoomOut size={16} />
                </button>
                <span className="btn btn-outline-secondary disabled px-3 py-0" style={{ minWidth: "60px", textAlign: "center" }}>
                  {Math.round(scale * 100)}%
                </span>
                <button className="btn btn-outline-secondary" onClick={handleZoomIn} title="Zoom in">
                  <IconZoomIn size={16} />
                </button>
              </div>
              <button className="btn btn-outline-secondary btn-sm" onClick={handleRotate} title="Rotate">
                <IconRotate size={16} />
              </button>
              <button className="btn btn-outline-secondary btn-sm" onClick={handleDownload} title="Download">
                <IconDownload size={16} />
              </button>
              <div className="vr mx-2"></div>
              <div className="btn-group btn-group-sm" role="group">
                <button
                  className="btn btn-outline-secondary"
                  onClick={() => onPageChange(Math.max(1, pageNumber - 1))}
                  disabled={pageNumber <= 1}
                  title="Previous page"
                >
                  <IconChevronLeft size={16} />
                </button>
                <input
                  type="number"
                  className="form-control form-control-sm text-center"
                  style={{ width: "70px" }}
                  min={1}
                  max={numPages || 1}
                  value={pageNumber}
                  onChange={(e) => {
                    const val = parseInt(e.target.value, 10);
                    if (!isNaN(val) && val >= 1 && val <= (numPages || 1)) {
                      onPageChange(val);
                    }
                  }}
                  onBlur={(e) => {
                    const val = parseInt(e.target.value, 10);
                    if (isNaN(val) || val < 1 || val > (numPages || 1)) {
                      e.target.value = pageNumber.toString();
                    }
                  }}
                />
                <span className="btn btn-outline-secondary disabled px-2" style={{ borderRadius: 0 }}>
                  / {numPages || "?"}
                </span>
                <button
                  className="btn btn-outline-secondary"
                  onClick={() => onPageChange(Math.min(numPages || 1, pageNumber + 1))}
                  disabled={pageNumber >= (numPages || 1)}
                  title="Next page"
                >
                  <IconChevronRight size={16} />
                </button>
              </div>
            </div>
          </div>
        </nav>

        <main style={{ flex: 1, overflow: "auto", display: "flex", alignItems: "center", justifyContent: "center", background: "#e0e0e0", padding: "2rem" }}>
          <Document
            file={href}
            onLoadSuccess={onDocumentLoadSuccess}
            onLoadError={onLoadError}
            loading={(
              <div className="text-center p-5">
                <div className="spinner-border text-primary" role="status">
                  <span className="visually-hidden">Loading page...</span>
                </div>
                <p className="mt-2 text-muted">Loading page {pageNumber}...</p>
              </div>
            )}
            error={(
              <div className="text-center p-5 text-danger">
                <IconAlertCircle size={48} className="mb-3" />
                <p>Failed to load page {pageNumber}</p>
              </div>
            )}
          >
            <div style={{
                transform: rotation ? `rotate(${rotation}deg)` : undefined,
                transformOrigin: 'center center',
              }}>
            <Page
              pageNumber={pageNumber}
              scale={scale}
              renderTextLayer={true}
              renderAnnotationLayer={true}
              onRenderSuccess={() => {}}
            />
            </div>
          </Document>
        </main>
      </div>
    </div>
  );
};

export default BookReader;