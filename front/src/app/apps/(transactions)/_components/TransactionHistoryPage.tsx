"use client";
import React, { useEffect, useMemo, useState } from "react";
import { Container, Card, CardBody } from "reactstrap";
import { getMyBookPlanPayments, BookPlanPayment } from "@/lib/api/bookPlans";
import {
  getWalletTransactions,
  WalletTransaction,
} from "@/lib/api/books";

type HistoryRow = {
  key: string;
  date: string;
  title: string;
  subtitle: string;
  points: number;
  amount?: string;
  status?: string;
};

const UNLOCK_PREFIX = "Unlocked book:";

function bookTitleFromDescription(description: string): string {
  const index = description.indexOf(UNLOCK_PREFIX);
  if (index === -1) return description;
  return description.slice(index + UNLOCK_PREFIX.length).trim();
}

function toWalletRow(tx: WalletTransaction): HistoryRow {
  const isBookUnlock =
    tx.type === "debit" && tx.description.startsWith(UNLOCK_PREFIX);

  return {
    key: `wallet-${tx.id}`,
    date: tx.created_at,
    title: isBookUnlock
      ? `Unlocked: ${bookTitleFromDescription(tx.description)}`
      : tx.description,
    subtitle: `Ref: ${tx.reference}`,
    points: tx.type === "credit" ? tx.amount : -tx.amount,
  };
}

function toPaymentRow(payment: BookPlanPayment): HistoryRow {
  return {
    key: `payment-${payment.id}`,
    date: payment.created_at ?? "",
    title: payment.plan?.name ?? "Points purchase",
    subtitle: `Ref: ${payment.payment_reference ?? "-"}`,
    points: payment.points ?? 0,
    amount: `${payment.amount} ${payment.currency}`,
    status: payment.status,
  };
}

function formatDate(value: string): string {
  if (!value) return "";
  const date = new Date(value);
  return Number.isNaN(date.getTime()) ? value : date.toLocaleString();
}

const TransactionHistoryPage = () => {
  const [rows, setRows] = useState<HistoryRow[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    let cancelled = false;

    const load = async () => {
      const [payments, wallet] = await Promise.all([
        getMyBookPlanPayments().catch(() => [] as BookPlanPayment[]),
        getWalletTransactions().catch(() => [] as WalletTransaction[]),
      ]);

      if (cancelled) return;

      const merged = [...payments.map(toPaymentRow), ...wallet.map(toWalletRow)]
        .sort((a, b) => {
          const aTime = a.date ? new Date(a.date).getTime() : 0;
          const bTime = b.date ? new Date(b.date).getTime() : 0;
          return bTime - aTime;
        });

      setRows(merged);
      setLoading(false);
    };

    load();

    return () => {
      cancelled = true;
    };
  }, []);

  const hasRows = useMemo(() => rows.length > 0, [rows.length]);

  return (
    <Container fluid>
      <h5 className="mb-3">Transaction History</h5>
      {loading ? (
        <p>Loading...</p>
      ) : !hasRows ? (
        <p>No transactions yet.</p>
      ) : (
        rows.map((r) => (
          <Card key={r.key} className="mb-3 border">
            <CardBody>
              <div className="d-flex justify-content-between mb-2">
                <strong>{r.title}</strong>
                <span
                  className={`badge ${
                    r.points < 0 ? "bg-danger" : "bg-success"
                  }`}
                >
                  {r.points > 0 ? "+" : ""}
                  {r.points} pts
                </span>
              </div>
              <div className="small text-muted mb-1">{r.subtitle}</div>
              <div className="d-flex justify-content-between">
                <span>
                  {r.amount ??
                    (r.points < 0 ? "Points used" : "Points added")}
                </span>
                {r.status && (
                  <span
                    className={`badge ${
                      r.status === "verified" || r.status === "active"
                        ? "bg-success"
                        : "bg-primary"
                    }`}
                  >
                    {r.status}
                  </span>
                )}
              </div>
              <div className="small text-muted mt-1">{formatDate(r.date)}</div>
            </CardBody>
          </Card>
        ))
      )}
    </Container>
  );
};

export default TransactionHistoryPage;