"use client";
import React from "react";
import { Container, Row } from "reactstrap";
import EcommerceCard from "./EcommerceCard";
import EcommerceDetail from "./EcommerceDetail";
import TopProduct from "./TopProduct";

const EcommerceDashboard = () => {
  return (
    <Container fluid className="mt-3">
      <Row>
        <EcommerceCard />
        <EcommerceDetail />
        <TopProduct />
      </Row>
    </Container>
  );
};

export default EcommerceDashboard;
