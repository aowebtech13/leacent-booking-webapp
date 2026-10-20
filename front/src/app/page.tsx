import SignInPage from "@/app/auth-pages/(sign-in)/_components/SignInPage";

/**
 * The landing route renders the sign in page in place (no redirect) so the
 * browser URL always matches the rendered content. A redirect declared in
 * `next.config.ts` would be resolved at the HTTP layer: the Next.js client
 * router follows it transparently while keeping the original URL, which made
 * the app chrome (sidebar/header) wrap the auth page.
 *
 * Signed in visitors are forwarded to the app by the sign in page itself.
 */
export default function HomePage() {
  return (
    <div>
      <SignInPage />
    </div>
  );
}
