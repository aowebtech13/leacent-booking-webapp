import type { Metadata } from "next";
import VerifyOtpForm from "./_components/VerifyOtpForm";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Verify OTP - Axelit",
    description: "Verify your OTP to complete the process",
  };
}

const Page = () => {
  return <VerifyOtpForm />;
};

export default Page;
