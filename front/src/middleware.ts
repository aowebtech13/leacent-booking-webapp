import { NextResponse } from "next/server";
import type { NextRequest } from "next/server";

const PROTECTED_PATHS = ["/dashboard", "/apps", "/profile"];

export function middleware(request: NextRequest) {
  const { pathname } = request.nextUrl;
  
  const isProtected = PROTECTED_PATHS.some((path) => pathname.startsWith(path));
  
  if (!isProtected) {
    return NextResponse.next();
  }
  
  // Check for auth token in cookies or localStorage isn't available in middleware
  // Check common auth cookie names
  const token = 
    request.cookies.get("leacent_auth_token")?.value ||
    request.cookies.get("auth_token")?.value ||
    request.cookies.get("token")?.value ||
    request.headers.get("authorization")?.replace("Bearer ", "");
  
  // Also check for session cookie from Sanctum
  const sessionCookie = request.cookies.get("laravel_session")?.value;
  
  if (!token && !sessionCookie) {
    const loginUrl = new URL("/auth-pages/sign-in", request.url);
    loginUrl.searchParams.set("redirect", pathname);
    return NextResponse.redirect(loginUrl);
  }
  
  return NextResponse.next();
}

export const config = {
  matcher: ["/dashboard/:path*", "/apps/:path*", "/profile/:path*"],
};
