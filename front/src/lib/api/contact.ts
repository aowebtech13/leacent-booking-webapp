import api from "./client";

export interface ContactMessageInput {
  name: string;
  email: string;
  phone?: string | undefined;
  subject?: string | undefined;
  message: string;
}

/**
 * Send a "Contact Us" message. Posts to the Laravel `POST /api/contact`
 * endpoint which emails the Business Labs team.
 */
export function sendContactMessage(
  data: ContactMessageInput
): Promise<{ message?: string }> {
  return api.post("contact", data);
}