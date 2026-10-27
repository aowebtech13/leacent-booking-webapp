export class ActionError extends Error {
  status: number | undefined;
  data?: any;

  constructor(message: string, status?: number, data?: any) {
    super(message);
    this.name = "ActionError";
    this.status = status;
    this.data = data;
  }
}

export function toActionError(error: any): ActionError {
  if (error instanceof ActionError) {
    return error;
  }

  if (error?.response?.data) {
    const data = error.response.data;
    const message = data?.message || data?.error || "An error occurred";
    const status = error?.response?.status;
    return new ActionError(message, status, data);
  }

  if (error?.message) {
    return new ActionError(error.message, error?.status, error?.data);
  }

  return new ActionError("An unexpected error occurred");
}
