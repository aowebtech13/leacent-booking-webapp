/**
 * Error shape returned by the API layer when a request fails.
 * Server actions throw this so the UI can surface the message.
 */
export class ActionError extends Error {
  status: number | undefined;
  data: any;
  constructor(message: string, status?: number, data?: any) {
    super(message);
    this.name = "ActionError";
    this.status = status;
    this.data = data;
  }
}

/**
 * Next.js implements redirects by throwing an error with a NEXT_REDIRECT
 * digest. When a server action redirects, the promise of the action rejects
 * with that error so the framework can navigate. UI code that wraps a server
 * action (for example inside `useActionState`) has to re-throw it, otherwise
 * the redirect is swallowed and the user stays on the current page.
 */
export function isRedirectError(error: any): boolean {
  const digest = error?.digest ?? error?.cause?.digest;
  return typeof digest === "string" && digest.startsWith("NEXT_REDIRECT");
}

/**
 * Wrap an unknown error thrown by the API layer into an ActionError so the
 * UI layer can reliably read `error.message`.
 */
export function toActionError(error: any): ActionError {
  if (error instanceof ActionError) return error;

  // Next.js implements redirects by throwing an error with a NEXT_REDIRECT
  // digest. It must be re-thrown as-is, otherwise a successful action that
  // redirects would be reported to the user as a failure.
  if (isRedirectError(error)) {
    throw error;
  }

  const hasResponse = Boolean(error?.response);
  const message = hasResponse
    ? error?.message ||
      error?.response?.data?.message ||
      error?.data?.message ||
      "Something went wrong"
    : "Unable to connect to the server. Please try again later.";
  const status = error?.status || error?.response?.status;
  const data = error?.data || error?.response?.data;
  return new ActionError(message, status, data);
}
