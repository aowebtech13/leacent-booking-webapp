"use client";

import React, { Suspense, useState, ReactNode, useEffect } from "react";
import TopGo from "../CommonElements/TopGo";
import Loading from "@/app/loading";
import Loader from "@/Component/CommonElements/Loader";
import Sidebar from "@/Component/Layouts/Sidebar";
import Header from "@/Component/Layouts/Header";
import Footer from "@/Component/Layouts/Footer";
import { usePathname, useRouter } from "next/navigation";
import Image from "next/image";
import { useAuth } from "@/lib/contexts/AuthContext";

import { Modal, ModalBody, ModalFooter } from "reactstrap";

interface DefaultLayoutProps {
  children: ReactNode;
}

/**
 * Routes rendered without the dashboard chrome (sidebar/header/footer),
 * e.g. the landing page, auth screens and error pages.
 */
const CHROMELESS_PATTERNS = [
  "/auth-pages",
  "/verify-otp",
  "/error-pages",
  "/other-pages/maintenance",
  "/other-pages/coming-soon",
];

/**
 * Routes reachable without a session. Everything not matched here is treated
 * as part of the authenticated app and must not paint its chrome until the
 * auth state has been resolved.
 */
const PUBLIC_PATTERNS = [
  ...CHROMELESS_PATTERNS,
  "/other-pages/landing",
  "/other-pages/privacy-policy",
  "/other-pages/terms-condition",
  "/other-pages/sitemap",
];

function matchesAny(pathname: string, patterns: string[]): boolean {
  if (pathname === "/") return true;
  return patterns.some((pattern) => pathname.includes(pattern));
}

const DefaultLayout: React.FC<DefaultLayoutProps> = ({ children }) => {
  const [sidebarOpen, setSidebarOpen] = useState<boolean>(false);
  const [welcomeModal, setWelcomeModal] = useState<boolean>(false);
  const pathname = usePathname();
  const router = useRouter();
  const { isAuthenticated, isLoading } = useAuth();

  const showChrome = !matchesAny(pathname, CHROMELESS_PATTERNS);
  const requiresAuth = !matchesAny(pathname, PUBLIC_PATTERNS);

  useEffect(() => {
    const head = document.getElementsByTagName("head")[0];

    for (const weight of [
      "regular",
      "thin",
      "light",
      "bold",
      "fill",
      "duotone",
    ]) {
      const link = document.createElement("link");
      link.rel = "stylesheet";
      link.type = "text/css";
      link.href = `https://unpkg.com/@phosphor-icons/web@2.0.3/src/${weight}/style.css`;
      if (head) {
        head.appendChild(link);
      }
    }
    if (pathname === "/dashboard") {
      setWelcomeModal(true);
    }
  }, [pathname]);

  // Send unauthenticated visitors on protected routes to sign-in, preserving
  // the URL they originally requested so they can be returned after login.
  useEffect(() => {
    if (!requiresAuth || isLoading || isAuthenticated) return;
    const search = typeof window !== "undefined" ? window.location.search : "";
    router.replace(
      `/auth-pages/sign-in?redirect=${encodeURIComponent(`${pathname}${search}`)}`
    );
  }, [requiresAuth, isLoading, isAuthenticated, pathname, router]);

  if (!showChrome) {
    return <>{children}</>;
  }

  // Protected route: never render the app shell (sidebar/header/footer) until
  // the session is confirmed, otherwise it flashes before the redirect.
  if (requiresAuth && (isLoading || !isAuthenticated)) {
    return <Loader />;
  }

  const toggleWelcomeModal = () => setWelcomeModal(!welcomeModal);

  return (
    <div className="app-wrapper default">
      <Suspense fallback={<Loading />}>
        <Sidebar sidebarOpen={sidebarOpen} setSidebarOpen={setSidebarOpen} />
        <div className="app-content">
          <Header sidebarOpen={sidebarOpen} setSidebarOpen={setSidebarOpen} />
          <main>{children}</main>
          <TopGo />
          <Footer />
        </div>

        <Modal
          isOpen={welcomeModal}
          toggle={toggleWelcomeModal}
          centered={true}
          backdrop="static"
          className="welcome-modal"
        >
          <div className="modal-content welcome-card">
            <ModalBody className="p-0">
              <div className="text-center position-relative welcome-card-content z-1 p-3">
                <div className="text-end position-relative z-1 me-2">
                  <i
                    className="ti ti-x fs-5 text-primary f-w-600 cursor-pointer"
                    onClick={toggleWelcomeModal}
                  ></i>
                </div>
                <h2 className="f-w-700 text-primary-dark mb-0">
                  <span>Welcome!</span>{" "}
                </h2>

                <div className="modal-img-box">
                  <Image
                    alt="img"
                    className="img-fluid"
                    src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791754748/pexels-sahfy-lenz-2153643467-36895469_q1rtht.jpg"
                    width={1280}
                    height={1600}
                    sizes="(max-width: 768px) 100vw, 50vw"
                    priority
                  />
                </div>
                <ModalFooter className="modal-btn mb-4 justify-content-center">
                  <button
                    className="btn btn-primary text-white btn-sm rounded"
                    onClick={toggleWelcomeModal}
                    type="button"
                  >
                    start Reading
                  </button>
                </ModalFooter>
              </div>
            </ModalBody>
          </div>
        </Modal>
      </Suspense>
    </div>
  );
};

export default DefaultLayout;