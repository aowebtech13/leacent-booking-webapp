import type { Metadata } from "next";
import { cookies } from "next/headers";
import VerifyOtpForm from "./_components/VerifyOtpForm";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Verify OTP - Leacent",
    description: "Verify your OTP to complete the process",
  };
}

export default async function Page({
  searchParams,
}: {
  searchParams: Promise<{ [key: string]: string | string[] | undefined }>;
}) {
  const cookieStore = await cookies();
  const email = cookieStore.get("pending_email")?.value ?? null;
  const params = await searchParams;
  const rawPurpose = params.purpose;
  const purpose = typeof rawPurpose === "string" ? rawPurpose : undefined;

  return (
    <VerifyOtpForm
      email={email}
      {...(purpose ? { purpose } : {})}
    />
  );
}
