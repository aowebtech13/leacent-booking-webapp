"use client";

import { Col, Container, Row } from "reactstrap";
import HeaderMenu from "@/Component/Layouts/Header/HeaderMenu";
import React from "react";
import { SidebarProps } from "@/interface/common";
import { CirclesFour } from "phosphor-react";
import Link from "next/link";
import { usePathname } from "next/navigation";

const Header: React.FC<SidebarProps> = ({ sidebarOpen, setSidebarOpen }) => {
  const pathname = usePathname();
  const isLandingPage = pathname === "/other-pages/landing";

  if (isLandingPage) {
    return (
      <header className="header-main landing-header">
        <Container fluid>
          <Row className="align-items-center">
            <Col xs="12" className="d-flex align-items-center justify-content-between p-0">
              <Link href="/dashboard" className="logo">
                <img
                  alt="Leacent Logo"
                  src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png"
                  height="40"
                />
              </Link>
              <nav className="d-none d-md-flex">
                <ul className="d-flex align-items-center gap-4 mb-0 landing-nav">
                  <li>
                    <Link href="/dashboard" className="nav-link text-dark f-w-500">
                      Home
                    </Link>
                  </li>
                  <li>
                    <Link href="/apps/book-library" className="nav-link text-dark f-w-500">
                      Books
                    </Link>
                  </li>
                  <li>
                    <Link href="/apps/pricing" className="nav-link text-dark f-w-500">
                      Points Purchase
                    </Link>
                  </li>
                  <li>
                    <Link href="/apps/contact" className="nav-link text-dark f-w-500">
                      Contact Us
                    </Link>
                  </li>
                </ul>
              </nav>
              <div className="d-flex align-items-center gap-2">
                <Link href="/apps/pricing" className="btn btn-primary rounded-pill d-none d-md-inline-block">
                  Get Started
                </Link>
              </div>
            </Col>
          </Row>
        </Container>
      </header>
    );
  }

  return (
    <header className="header-main">
      <Container fluid>
        <Row>
          <Col
            xs="6"
            sm="4"
            className="d-flex align-items-center header-left p-0"
          >
            <span
              className="header-toggle me-3"
              onClick={() => setSidebarOpen?.(!sidebarOpen)}
            >
              <CirclesFour size={20} />
            </span>
          </Col>
          <Col
            xs="6"
            sm="8"
            className="d-flex align-items-center justify-content-end header-right p-0"
          >
            <HeaderMenu />
          </Col>
        </Row>
      </Container>
    </header>
  );
};

export default Header;
