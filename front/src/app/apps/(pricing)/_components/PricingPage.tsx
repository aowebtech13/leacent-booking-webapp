"use client";
import React from "react";
import { Card, CardBody, CardHeader, Row, Col, Container } from "reactstrap";
import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";
import SimplePricingCard from "@/app/apps/(pricing)/_components/SimplePricingCard";
import ComparePricing from "@/app/apps/(pricing)/_components/ComparePricing";

import { IconStack2 } from "@tabler/icons-react";

const PricingPage = () => {
  return (
    <div>
      <Container fluid>
        <Breadcrumbs
          mainTitle="Pricing"
          title="Apps"
          path={["Pricing"]}
          Icon={IconStack2 as any}
        />
        <Row>
        

          <Col xs={12}>
            <Card>
              <CardHeader>
                <h5>Subscription Price</h5>
              </CardHeader>
              <CardBody>
                <SimplePricingCard />
              </CardBody>
            </Card>
          </Col>

          <Col xs={12}>
            <Card>
              <CardHeader>
                <h5>Compare plans</h5>
              </CardHeader>
              <CardBody>
                <ComparePricing />
              </CardBody>
            </Card>
          </Col>
        </Row>
      </Container>
    </div>
  );
};

export default PricingPage;
