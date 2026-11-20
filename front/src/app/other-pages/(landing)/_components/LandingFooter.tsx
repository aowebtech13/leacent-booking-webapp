import React from "react";
import { Col, Container, Row } from "reactstrap";
import Image from "next/image";

const LandingFooter = () => {
  return (
    <Container>
      <Row>
        <Col className="footer-content text-center">
          <Image
            src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png"
            alt="logo"
            width={120}
            height={40}
          />
          <h1>
            Join <span className="highlight-title"> Business </span> lab Today
            !!
          </h1>
          <p className="txt-ellipsis-3">
            The Business Lab - Books & Movies ~ Built By Aowebtech
          </p>
        </Col>
      </Row>
    </Container>
  );
};

export default LandingFooter;
