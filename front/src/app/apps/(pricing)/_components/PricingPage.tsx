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
import ComparePricing from "@/app/apps/(pricing)/_components/ComparePricing";
import SubscribePlanModal from "@/app/apps/(pricing)/_components/SubscribePlanModal";

import { IconStack2 } from "@tabler/icons-react";
import { useRouter } from "next/navigation";
import {
  BookPlan,
  SubscriptionPayment,
  getBookPlans,
  getMySubscriptionPayments,
} from "@/lib/api";
import { useAuth } from "@/lib/contexts/AuthContext";

const PricingPage = () => {
  const { isAuthenticated, isLoading: authLoading } = useAuth();
  const router = useRouter();

  const [plans, setPlans] = useState<BookPlan[]>([]);
  const [plansLoading, setPlansLoading] = useState(true);
  const [plansError, setPlansError] = useState<string | null>(null);

  const [payments, setPayments] = useState<SubscriptionPayment[]>([]);
  const [selectedPlan, setSelectedPlan] = useState<BookPlan | null>(null);
  const [modalOpen, setModalOpen] = useState(false);

  const loadPlans = useCallback(async () => {
    setPlansLoading(true);
    setPlansError(null);
    try {
      const data = await getBookPlans();
      setPlans(data ?? []);
    } catch (err: any) {
      setPlansError(err?.message || "Failed to load subscription plans");
    } finally {
      setPlansLoading(false);
    }
  }, []);

  const loadPayments = useCallback(async () => {
    try {
      const data = await getMySubscriptionPayments();
      setPayments(data ?? []);
    } catch {
      setPayments([]);
    }
  }, []);

  useEffect(() => {
    loadPlans();
  }, [loadPlans]);

  useEffect(() => {
    if (authLoading) return;
    if (!isAuthenticated) {
      setPayments([]);
      return;
    }
    loadPayments();
  }, [isAuthenticated, authLoading, loadPayments]);

  const handleSubscribe = (plan: BookPlan) => {
    if (!isAuthenticated) {
      router.push("/sign-in");
      return;
    }
    setSelectedPlan(plan);
    setModalOpen(true);
  };

  const handleSubmitted = (payment: SubscriptionPayment) => {
    setPayments((prev) => [
      payment,
      ...prev.filter((p) => p.id !== payment.id),
    ]);
  };

  const latestPayment = payments[0];

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
            <Link href="/sign-in" className="f-w-600">
              Sign in
            </Link>{" "}
            to subscribe. Payments are made by bank transfer and verified
            manually by our team.
          </Alert>
        )}

        {isAuthenticated && latestPayment && (
          <Alert
            color={
              latestPayment.status === "active"
                ? "success"
                : latestPayment.status === "pending"
                  ? "warning"
                  : "danger"
            }
            className="mx-3"
          >
            {latestPayment.status === "active" && (
              <>
                Your {latestPayment.plan?.name} subscription is active. Your
                access is confirmed.
              </>
            )}
            {latestPayment.status === "pending" && (
              <>
                Your {latestPayment.plan?.name} payment (
                {latestPayment.payment_reference}) is awaiting verification.
                {latestPayment.has_receipt
                  ? " We received your receipt and will activate your access shortly."
                  : " Upload your payment receipt to complete the process."}
              </>
            )}
            {latestPayment.status === "failed" && (
              <>
                Your {latestPayment.plan?.name} payment could not be verified
                {latestPayment.rejection_reason
                  ? `: ${latestPayment.rejection_reason}`
                  : "."}{" "}
                You can subscribe again below.
              </>
            )}
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
                <h5>Subscription Price</h5>
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

          <Col xs={12}>
            <Card>
              <CardHeader>
                <h5>Compare plans</h5>
              </CardHeader>
              <CardBody>
                <ComparePricing plans={plans} />
              </CardBody>
            </Card>
          </Col>
        </Row>
      </Container>

      <SubscribePlanModal
        plan={selectedPlan}
        isOpen={modalOpen}
        onClose={() => setModalOpen(false)}
        onSubmitted={handleSubmitted}
      />
    </div>
  );
};

export default PricingPage;
