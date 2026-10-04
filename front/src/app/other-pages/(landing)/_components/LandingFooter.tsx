import React from "react";
import { Button, Col, Container, Row } from "reactstrap";

const LandingFooter = () => {
  return (
    <Container>
      <Row>
        <Col className="footer-content text-center">
          <img src="/images/logo/4.png" alt="logo" />
          <h1>
            Build a <span className="highlight-title"> Startling </span> site
          </h1>
          <p className="txt-ellipsis-3">
            Purchase The axelit & Craft Your Site Super Faster And Powerful.
            Discover the axelit Admin Theme. If you enjoy our template, please
            take a moment to rate us.
          </p>
          <div className="footer-btn">
            <Button
              href="https://themeforest.net/user/la-themes"
              target="_blank"
              color="primary"
              size="lg"
              className="me-3"
            >
              Buy Now
            </Button>
            <Button
              href="mailto:teqlathemes@gmail.com."
              target="_blank"
              color="danger"
              size="lg"
            >
              Need Help?
            </Button>
          </div>
        </Col>
      </Row>
    </Container>
  );
};

export default LandingFooter;
