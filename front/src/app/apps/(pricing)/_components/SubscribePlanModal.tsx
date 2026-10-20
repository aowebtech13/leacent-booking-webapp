"use client";
import React, { useEffect, useState } from "react";
import {
  Alert,
  Button,
  Modal,
  ModalBody,
  ModalFooter,
  ModalHeader,
  Spinner,
} from "reactstrap";
import { Bank, CheckCircle, Copy, FileArrowUp, Receipt } from "phosphor-react";
import {
  BookPlan,
  SubscriptionPayment,
  subscribeToPlan,
  uploadSubscriptionReceipt,
} from "@/lib/api";

interface SubscribePlanModalProps {
  plan: BookPlan | null;
  isOpen: boolean;
  onClose: () => void;
  onSubmitted?: (payment: SubscriptionPayment) => void;
}

const formatMoney = (amount: number, currency?: string) => {
  const value = Number.isFinite(amount) ? amount : 0;

  try {
    return new Intl.NumberFormat("en-NG", {
      style: "currency",
      currency: currency || "NGN",
      maximumFractionDigits: Number.isInteger(value) ? 0 : 2,
    }).format(value);
  } catch {
    return `${currency || "NGN"} ${value.toLocaleString()}`;
  }
};

const SubscribePlanModal: React.FC<SubscribePlanModalProps> = ({
  plan,
  isOpen,
  onClose,
  onSubmitted,
}) => {
  const [payment, setPayment] = useState<SubscriptionPayment | null>(null);
  const [loading, setLoading] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [success, setSuccess] = useState<string | null>(null);
  const [copied, setCopied] = useState<string | null>(null);
  const [receipt, setReceipt] = useState<File | null>(null);

  // Start (or resume) the subscription as soon as the modal opens.
  useEffect(() => {
    if (!isOpen || !plan) return;

    let cancelled = false;
    setError(null);
    setSuccess(null);
    setReceipt(null);

    const start = async () => {
      setLoading(true);
      try {
        const data = await subscribeToPlan(plan.id);
        if (!cancelled) setPayment(data);
      } catch (err: any) {
        if (!cancelled)
          setError(
            err?.message ||
              "Unable to start this subscription. Please try again."
          );
      } finally {
        if (!cancelled) setLoading(false);
      }
    };

    start();

    return () => {
      cancelled = true;
    };
  }, [isOpen, plan]);

  const copyToClipboard = async (label: string, value: string) => {
    try {
      await navigator.clipboard.writeText(value);
      setCopied(label);
      setTimeout(() => setCopied(null), 2000);
    } catch {
      setError("Could not copy to clipboard.");
    }
  };

  const handleReceiptChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setReceipt(e.target.files?.[0] ?? null);
  };

  const handleSubmit = async () => {
    if (!payment || !receipt) return;

    setSubmitting(true);
    setError(null);

    try {
      const formData = new FormData();
      formData.append("receipt", receipt);

      const updated = await uploadSubscriptionReceipt(payment.id, formData);
      setPayment(updated);
      setSuccess(
        "Receipt submitted. Our team verifies bank transfers manually, and your access is activated once the payment is confirmed."
      );
      setReceipt(null);
      onSubmitted?.(updated);
    } catch (err: any) {
      setError(
        err?.message || "Could not upload the receipt. Please try again."
      );
    } finally {
      setSubmitting(false);
    }
  };

  const bank = payment?.bank;

  return (
    <Modal isOpen={isOpen} toggle={onClose} size="lg">
      <ModalHeader toggle={onClose}>Subscribe to {plan?.name}</ModalHeader>
      <ModalBody>
        {error && <Alert color="danger">{error}</Alert>}

        {loading && (
          <div className="text-center py-4">
            <Spinner color="primary" /> <span>Preparing your payment…</span>
          </div>
        )}

        {!loading && payment && (
          <>
            <div className="mb-3">
              <h6 className="mb-1">Amount to transfer</h6>
              <h4 className="mb-0 text-primary">
                {formatMoney(payment.amount, payment.currency)}
              </h4>
              <p className="mb-0 f-s-13 text-muted">
                {payment.plan?.name} · access for{" "}
                {payment.plan?.access_duration_days} days
              </p>
            </div>

            {bank && (
              <div className="border rounded p-3 mb-3">
                <h6 className="mb-3">
                  <Bank size={18} className="me-1" /> Bank transfer details
                </h6>

                <div className="d-flex justify-content-between align-items-center mb-2">
                  <span className="text-muted">Account Name</span>
                  <span className="f-w-600 text-end">
                    {bank.account_name}{" "}
                    <Button
                      color="link"
                      size="sm"
                      className="p-0 ms-1 align-text-top"
                      onClick={() => copyToClipboard("name", bank.account_name)}
                    >
                      {copied === "name" ? (
                        <CheckCircle
                          size={16}
                          weight="fill"
                          className="text-success"
                        />
                      ) : (
                        <Copy size={16} />
                      )}
                    </Button>
                  </span>
                </div>

                <div className="d-flex justify-content-between align-items-center mb-2">
                  <span className="text-muted">Account Number</span>
                  <span className="f-w-600 text-end">
                    {bank.account_number}{" "}
                    <Button
                      color="link"
                      size="sm"
                      className="p-0 ms-1 align-text-top"
                      onClick={() =>
                        copyToClipboard("number", bank.account_number)
                      }
                    >
                      {copied === "number" ? (
                        <CheckCircle
                          size={16}
                          weight="fill"
                          className="text-success"
                        />
                      ) : (
                        <Copy size={16} />
                      )}
                    </Button>
                  </span>
                </div>

                <div className="d-flex justify-content-between align-items-center mb-2">
                  <span className="text-muted">Bank</span>
                  <span className="f-w-600 text-end">{bank.bank_name}</span>
                </div>

                <div className="d-flex justify-content-between align-items-center">
                  <span className="text-muted">Payment Reference</span>
                  <span className="f-w-600 text-end">
                    {payment.payment_reference ?? "N/A"}
                  </span>
                </div>

                {bank.instructions && (
                  <p className="f-s-13 text-muted mt-3 mb-0">
                    {bank.instructions}
                  </p>
                )}
              </div>
            )}

            {success ? (
              <Alert color="success" className="mb-0">
                <Receipt size={18} className="me-1" /> {success}
              </Alert>
            ) : (
              <div>
                <h6 className="mb-2">Upload your payment receipt</h6>
                <input
                  type="file"
                  accept="image/*"
                  className="form-control mb-2"
                  onChange={handleReceiptChange}
                />
                <p className="f-s-13 text-muted mb-0">
                  <FileArrowUp size={16} className="me-1" />
                  Upload a screenshot or photo of the transfer receipt (max
                  5MB). Payment verification is manual, so access is granted
                  after an admin confirms the transfer.
                </p>
              </div>
            )}
          </>
        )}
      </ModalBody>
      <ModalFooter>
        <Button color="secondary" onClick={onClose}>
          Close
        </Button>
        {!success && (
          <Button
            color="primary"
            onClick={handleSubmit}
            disabled={!payment || !receipt || submitting || loading}
          >
            {submitting ? (
              <>
                <Spinner size="sm" className="me-1" /> Submitting…
              </>
            ) : (
              "Submit for verification"
            )}
          </Button>
        )}
      </ModalFooter>
    </Modal>
  );
};

export default SubscribePlanModal;
