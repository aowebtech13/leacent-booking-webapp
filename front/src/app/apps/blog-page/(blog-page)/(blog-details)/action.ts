"use server";

export async function subscribeNewsletter(formData: FormData) {
  const email = formData.get("email");

  await new Promise((res) => setTimeout(res, 500));
  return email;
}
