"use client";

export default function GlobalError({
  error,
  reset,
}: {
  error: Error & { digest?: string };
  reset: () => void;
}) {
  console.error(error);

  return (
    <html>
      <head>
        <title>Error</title>
      </head>
      <body>
        <div className="d-flex flex-column align-items-center justify-content-center min-vh-100 text-center p-4">
          <h2 className="mb-3">Something went wrong</h2>
          <p className="text-muted mb-4">
            {error.message || "An unexpected error occurred. Please try again."}
          </p>
          <div className="mb-4 text-muted small">{error.digest}</div>
          <button className="btn btn-primary" onClick={() => reset()}>
            Try again
          </button>
        </div>
      </body>
    </html>
  );
}
