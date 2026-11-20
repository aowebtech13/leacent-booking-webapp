"use client";
import React, { useCallback, useEffect, useState } from "react";
import {
  Alert,
  Card,
  CardBody,
  CardHeader,
  Row,
  Col,
  Modal,
  ModalHeader,
  ModalBody,
  ModalFooter,
  Container,
  Button,
} from "reactstrap";
import Link from "next/link";
import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";
import { Copy } from "phosphor-react";
import SimplePricingCard from "@/app/apps/(pricing)/_components/SimplePricingCard";

import { IconStack2 } from "@tabler/icons-react";
import { useRouter } from "next/navigation";
import { BookPlan } from "@/lib/api";
import {
  buyPointsPlan,
  getBookPlans,
  uploadBookPlanReceipt,
} from "@/lib/api/bookPlans";
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

  const [payment, setPayment] = useState<any>(null);
  const [receiptFile, setReceiptFile] = useState<File | null>(null);
  const [uploading, setUploading] = useState(false);
  const [submitMsg, setSubmitMsg] = useState<string | null>(null);

  const handleSubscribe = async (plan: BookPlan) => {
    if (!isAuthenticated) {
      router.push("/auth-pages/sign-in");
      return;
    }
    setSelectedPlan(plan);
    try {
      const res = await buyPointsPlan(plan.id);
      setPayment(res);
      setModalOpen(true);
    } catch (err: any) {
      setPlansError(err?.message || "Failed to start purchase");
    }
  };

  return (
    <div>
      <Container fluid>
        <Breadcrumbs
          mainTitle="Purchase Plans"
          title="Apps"
          path={["Purchase Plans"]}
          Icon={IconStack2 as any}
        />

        <section className="pt-4 pb-5">
          <div className="row">
            <div className="col-12">
              <Card className="purchase-hero-card shadow-sm">
                <CardBody className="text-center p-4">
                  <h2 className="h4 mb-3">Purchase Point Plans</h2>
                  <p className="text-muted mb-4">
                    Add points to your account to book services on the platform.
                    Choose a package below, then pay by bank transfer.
                  </p>

                  <div className="row g-4 text-center">
                    <div className="col-md-4">
                      <div className="step">
                        <span className="step-badge rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center">
                          1
                        </span>
                        <h6 className="mt-2 mb-1">Browse plans</h6>
                        <p className="text-muted small mb-0">
                          Review the available point packages and their
                          features.
                        </p>
                      </div>
                    </div>
                    <div className="col-md-4">
                      <div className="step">
                        <span className="step-badge rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center">
                          2
                        </span>
                        <h6 className="mt-2 mb-1">Select a plan</h6>
                        <p className="text-muted small mb-0">
                          Tap &ldquo;Buy Points&rdquo; on the package you want.
                          You will be signed in if needed.
                        </p>
                      </div>
                    </div>
                    <div className="col-md-4">
                      <div className="step">
                        <span className="step-badge rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center">
                          3
                        </span>
                        <h6 className="mt-2 mb-1">Complete payment</h6>
                        <p className="text-muted small mb-0">
                          Transfer the amount to the shown bank account and
                          upload your receipt for verification.
                        </p>
                      </div>
                    </div>
                  </div>
                </CardBody>
              </Card>
            </div>
          </div>
        </section>

        {!isAuthenticated && !authLoading && (
          <Alert color="info" className="mx-3 mb-4">
            <Link href="/auth-pages/sign-in" className="f-w-600">
              Sign in
            </Link>{" "}
            before purchasing. Payments are made by bank transfer and verified
            manually by our team.
          </Alert>
        )}

        {plansError && (
          <Alert color="danger" className="mx-3 mb-4">
            {plansError}
          </Alert>
        )}

        <section className="pb-5">
          <Row>
            <Col xs={12}>
              <Card>
                <CardHeader>
                  <h5>Available Point Packages</h5>
                  <p className="mb-0 text-muted small">
                    150 ₦ = 1 point &bull; Pay by bank transfer
                  </p>
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
        </section>

        <Modal isOpen={modalOpen} toggle={() => setModalOpen(false)} size="md">
          <ModalHeader toggle={() => setModalOpen(false)}>
            {selectedPlan?.name} — Complete Payment
          </ModalHeader>
          <ModalBody>
            {submitMsg && (
              <div className="alert alert-info mt-2">{submitMsg}</div>
            )}
            {payment && (
              <div>
                <p className="mb-1">
                  <strong>Payment reference:</strong>{" "}
                  {payment.payment_reference}
                </p>
                <p className="mb-1">
                  <strong>Amount:</strong> {payment.amount} {payment.currency}
                </p>
                <p className="mb-1">
                  <strong>Bank:</strong> {payment.bank?.bank_name}
                </p>
                <p className="d-flex align-items-center gap-2 mb-1">
                  <strong>Account number:</strong>{" "}
                  {payment.bank?.account_number}
                  <button
                    className="btn btn-sm btn-outline-secondary p-1 ms-2"
                    onClick={() =>
                      navigator.clipboard.writeText(
                        payment.bank?.account_number ?? ""
                      )
                    }
                  >
                    <Copy size={16} />
                  </button>
                </p>
                <p className="mb-1">
                  <strong>Account name:</strong> {payment.bank?.account_name}
                </p>
                <p className="text-muted small mb-3">
                  {payment.bank?.instructions}
                </p>

                <div className="border rounded p-3 mb-3 bg-light">
                  <p className="mb-2 text-muted small f-w-500">
                    Step 1 — Transfer funds
                  </p>
                  <p className="mb-2">
                    Send the amount above to the account shown. Keep the
                    transfer receipt.
                  </p>
                  <p className="mb-0 text-muted small f-w-500">
                    Step 2 — Upload your receipt
                  </p>
                </div>

                <input
                  type="file"
                  accept="image/*"
                  onChange={(e) => setReceiptFile(e.target.files?.[0] ?? null)}
                  className="form-control mb-3"
                />
                <Button
                  color="primary"
                  className="w-100"
                  disabled={!receiptFile || uploading}
                  onClick={async () => {
                    if (!payment || !receiptFile) return;
                    setUploading(true);
                    try {
                      const fd = new FormData();
                      fd.append("receipt", receiptFile);
                      const res = await uploadBookPlanReceipt(payment.id, fd);
                      setPayment(res);
                      setSubmitMsg(
                        "Receipt submitted. Please wait for admin verification."
                      );
                      setTimeout(() => router.push("/dashboard"), 1500);
                    } catch (err: any) {
                      alert(err?.message || "Upload failed");
                    } finally {
                      setUploading(false);
                    }
                  }}
                >
                  {uploading ? "Uploading receipt…" : "Submit receipt"}
                </Button>
              </div>
            )}
          </ModalBody>
          <ModalFooter>
            <Button
              color="secondary"
              onClick={() => setModalOpen(false)}
              className="w-auto"
            >
              Close
            </Button>
          </ModalFooter>
        </Modal>
      </Container>
    </div>
  );
};

export default PricingPage;
