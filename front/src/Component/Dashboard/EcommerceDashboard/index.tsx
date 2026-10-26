"use client";
import React from "react";
import { Container, Row } from "reactstrap";
import EcommerceDetail from "./EcommerceDetail";
import TopProduct from "./TopProduct";
import EcommerceCard from "./EcommerceCard";


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
