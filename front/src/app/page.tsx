import { redirect } from "next/navigation";

export default function HomePage() {
  redirect("/auth-pages/sign-in");
}
