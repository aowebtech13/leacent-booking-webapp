"use client";

export default function Error({
  error,
  reset,
}: {
  error: Error & { digest?: string };
  reset: () => void;
}) {
  console.error(error);

  return (
    <div className="d-flex flex-column align-items-center justify-content-center min-vh-100 text-center p-4">
      <h2 className="mb-3">Something went wrong</h2>
      <p className="text-muted mb-4">
        {error.message || "An unexpected error occurred. Please try again."}
      </p>
      <div className="mb-4 text-left text-start">
        <small className="text-muted">{error.digest}</small>
      </div>
      <button className="btn btn-primary" onClick={() => reset()}>
        Try again
      </button>
    </div>
  );
}
