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
 * Wrap an unknown error thrown by the API layer into an ActionError so the
 * UI layer can reliably read `error.message`.
 */
export function toActionError(error: any): ActionError {
  if (error instanceof ActionError) return error;
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