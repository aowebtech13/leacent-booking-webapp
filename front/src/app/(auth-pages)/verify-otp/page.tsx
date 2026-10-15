import type { Metadata } from "next";
import { cookies } from "next/headers";
import VerifyOtpForm from "./_components/VerifyOtpForm";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Verify OTP - Axelit",
    description: "Verify your OTP to complete the process",
  };
}

const Page = async () => {
  const cookieStore = await cookies();
  const email = cookieStore.get("pending_email")?.value ?? null;
  return <VerifyOtpForm email={email} />;
};

export default Page;
