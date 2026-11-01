"use client";
import React, { useCallback, useEffect, useState } from "react";
import {
  Alert,
  Card,
  CardBody,
  CardHeader,
  Row,
  Col,
  Container,
} from "reactstrap";
import Link from "next/link";
import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";
import SimplePricingCard from "@/app/apps/(pricing)/_components/SimplePricingCard";

import { IconStack2 } from "@tabler/icons-react";
import { useRouter } from "next/navigation";
import { BookPlan, buyPointsPlan, getBookPlans } from "@/lib/api";
import { useAuth } from "@/lib/contexts/AuthContext";

const PricingPage = () => {
  const { isAuthenticated, isLoading: authLoading } = useAuth();
  const router = useRouter();

  const [plans, setPlans] = useState<BookPlan[]>([]);
  const [plansLoading, setPlansLoading] = useState(true);
  const [plansError, setPlansError] = useState<string | null>(null);
  const [selectedPlan, setSelectedPlan] = useState<BookPlan | null>(null);
  const [modalOpen, setModalOpen] = useState(false);

  const loadPlans = useCallback(async () => {
    setPlansLoading(true);
    setPlansError(null);
    try {
      const data = await getBookPlans();
      setPlans(data ?? []);
    } catch (err: any) {
      setPlansError(err?.message || "Failed to load point packages");
    } finally {
      setPlansLoading(false);
    }
  }, []);

  useEffect(() => {
    loadPlans();
  }, [loadPlans]);

  const handleSubscribe = (plan: BookPlan) => {
    if (!isAuthenticated) {
      router.push("/auth-pages/sign-in");
      return;
    }
    setSelectedPlan(plan);
    setModalOpen(true);
  };

  return (
    <div>
      <Container fluid>
        <Breadcrumbs
          mainTitle="Pricing"
          title="Apps"
          path={["Pricing"]}
          Icon={IconStack2 as any}
        />

        {!isAuthenticated && !authLoading && (
          <Alert color="info" className="mx-3">
            <Link href="/auth-pages/sign-in" className="f-w-600">
              Sign in
            </Link>{" "}
            to buy points. Payments are made by bank transfer and verified
            manually by our team.
          </Alert>
        )}

        {plansError && (
          <Alert color="danger" className="mx-3">
            {plansError}
          </Alert>
        )}

        <Row>
          <Col xs={12}>
            <Card>
              <CardHeader>
                <h5>Buy Points</h5>
              </CardHeader>
              <CardBody>
                <SimplePricingCard
                  plans={plans}
                  loading={plansLoading}
                  onSubscribe={handleSubscribe}
                />
              </CardBody>
            </Card>
          </Col>

        </Row>
      </Container>
    </div>
  );
};

export default PricingPage;
