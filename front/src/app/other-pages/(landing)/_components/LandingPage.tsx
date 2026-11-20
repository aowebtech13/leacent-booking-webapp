"use client";
import React, { useEffect, useRef, useState } from "react";
import { Container, Row, Col } from "reactstrap";
import Link from "next/link";
import Typed from "typed.js";

import DemoSection from "@/app/other-pages/(landing)/_components/DemoSection";
import PurchasePlanSection from "@/app/other-pages/(landing)/_components/PurchasePlanSection";
import FaqContentSection from "@/app/other-pages/(landing)/_components/FaqContentSection";
import LandingFooter from "@/app/other-pages/(landing)/_components/LandingFooter";

const LandingPage = () => {
  const [showScrollProgress, setShowScrollProgress] = useState(false);
  const [scrollPercentage, setScrollPercentage] = useState(0);
  const scrollProgressRef = useRef<HTMLDivElement>(null);
  const typedRef = useRef<HTMLSpanElement>(null);
  const typedInstance = useRef<Typed | null>(null);

  useEffect(() => {
    if (!typedRef.current) return;

    const options = {
      strings: [
        '<span class="highlight-text">Leacent <span class="txt-shadow">Work</span></span>',
        '<span class="highlight-text">Core <span class="txt-shadow">Goals</span></span>',
      ],
      typeSpeed: 100,
      backSpeed: 50,
      loop: true,
    };
    typedInstance.current = new Typed(typedRef.current, options);

    return () => {
      typedInstance.current?.destroy();
    };
  }, []);

  const [isOpen, setIsOpen] = useState(false);
  const [isScrolled, setIsScrolled] = useState(false);

  const toggle = () => setIsOpen(!isOpen);

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 50);
    };

    window.addEventListener("scroll", handleScroll);
    handleScroll();

    return () => {
      window.removeEventListener("scroll", handleScroll);
    };
  }, []);

  useEffect(() => {
    const handleScroll = () => {
      const pos = window.scrollY;
      const calcHeight = document.body.scrollHeight - window.innerHeight;
      const percentage = Math.round((pos * 100) / calcHeight);

      setShowScrollProgress(pos > 100);
      setScrollPercentage(percentage);
    };

    window.addEventListener("scroll", handleScroll);
    handleScroll();

    return () => {
      window.removeEventListener("scroll", handleScroll);
    };
  }, []);

  const [cursorStyle, setCursorStyle] = useState<React.CSSProperties>({});
  const circleRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    const mouse = { x: 0, y: 0 };
    const previousMouse = { x: 0, y: 0 };
    const circle = { x: 0, y: 0 };
    let currentScale = 0;
    let currentAngle = 0;
    let animationFrameId: number;

    const handleMouseMove = (e: MouseEvent) => {
      mouse.x = e.clientX;
      mouse.y = e.clientY;
    };

    const speed = 0.17;

    const tick = () => {
      circle.x += (mouse.x - circle.x) * speed;
      circle.y += (mouse.y - circle.y) * speed;

      const deltaMouseX = mouse.x - previousMouse.x;
      const deltaMouseY = mouse.y - previousMouse.y;
      previousMouse.x = mouse.x;
      previousMouse.y = mouse.y;

      const mouseVelocity = Math.min(
        Math.sqrt(deltaMouseX ** 2 + deltaMouseY ** 2) * 4,
        150
      );

      const scaleValue = (mouseVelocity / 150) * 0.5;
      currentScale += (scaleValue - currentScale) * speed;

      const angle = (Math.atan2(deltaMouseY, deltaMouseX) * 180) / Math.PI;
      if (mouseVelocity > 20) currentAngle = angle;
      setCursorStyle({
        transform: `translate(${circle.x}px, ${circle.y}px) 
                   scale(${1 + currentScale}, ${1 - currentScale}) 
                   rotate(${currentAngle}deg)`,
        willChange: "transform",
      });

      animationFrameId = requestAnimationFrame(tick);
    };

    window.addEventListener("mousemove", handleMouseMove);
    const initTimer = setTimeout(tick, 1000);

    return () => {
      window.removeEventListener("mousemove", handleMouseMove);
      clearTimeout(initTimer);
      cancelAnimationFrame(animationFrameId);
    };
  }, []);

  return (
    <div className="landing-page">
      <div ref={circleRef} className="circle-cursor" style={cursorStyle} />

      <div className="landing-wrapper">
        {/* landing first section start*/}
        <section className="landing-section p-0">
          <Container fluid>
            <Row className="landing-content">
              {/* Heading Section */}
              <Col lg="6" className="offset-lg-3 position-relative">
                <div className="landing-heading text-center">
                  <h1>
                    Welcome To <br />
                    <span ref={typedRef} id="highlight-typed"></span>
                    Business Labs - Books & Movies <br />
                  </h1>
                  <img
                    alt="shape"
                    className="img-fluid landing-vector-shape"
                    src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1795183879/stack-of-books_uarttj.png"
                  />
                  <p className="text-white">
                    Welcome to the real-life investment, entrepreneurship, and{" "}
                    <br />
                    business management resource Laboratory.
                  </p>
                  <div className="mt-5">
                    <Button
                      color="primary"
                      className="py-3 px-4 rounded-pill btn-lg"
                      href="/dashboard"
                      target="_blank"
                    >
                      Start Reading
                    </Button>
                  </div>
                </div>
              </Col>

              {/* Image Section */}
            </Row>
          </Container>
        </section>

        {/* landing first section end*/}
      </div>

      {/*demos section start */}
      <section className="demos-section" id="Demo">
        <DemoSection />
      </section>
      {/*demos section end */}

      {/*Faq section start */}
      <section className="faq-section">
        <FaqContentSection />
      </section>
      {/*Faq section end */}

      {/*card section end */}

      {/*Purchase Plans section start  */}
      <section className="plans-section">
        <PurchasePlanSection />
      </section>
      {/*Purchase Plans section end  */}

      {/*footer section start */}
      <section className="landing-footer">
        <LandingFooter />
      </section>
      {/*footer section end */}

      <div
        className="go-top"
        ref={scrollProgressRef}
        style={{
          display: showScrollProgress ? "grid" : "none",
          background: `conic-gradient(
        rgba(var(--primary), 1) ${scrollPercentage}%, 
        var(--light-gray) ${scrollPercentage}%
      )`,
        }}
        onClick={() => window.scrollTo({ top: 0, behavior: "smooth" })}
      >
        <span className="progress-value">
          <IconArrowNarrowUp size={35} />
        </span>
      </div>
    </div>
  );
};

export default LandingPage;
