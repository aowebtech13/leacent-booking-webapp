"use client";
import React, { useEffect, useState } from "react";
import { Container, Card, CardBody } from "reactstrap";
import { getMyBookPlanPayments } from "@/lib/api/bookPlans";

const TransactionHistoryPage = () => {
  const [rows, setRows] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    getMyBookPlanPayments()
      .then((data) => setRows(data ?? []))
      .finally(() => setLoading(false));
  }, []);

  return (
    <Container fluid>
      <h5 className="mb-3">Transaction History</h5>
      {loading ? (
        <p>Loading...</p>
      ) : rows.length === 0 ? (
        <p>No transactions yet.</p>
      ) : (
        rows.map((r) => (
          <Card key={r.id} className="mb-3 border">
            <CardBody>
              <div className="d-flex justify-content-between mb-2">
                <strong>{r.plan?.name ?? "Plan"}</strong>
                <span className={`badge ${r.status === "verified" ? "bg-success" : "bg-primary"}`}>
                  {r.status}
                </span>
              </div>
              <div className="small text-muted mb-1">Ref: {r.payment_reference}</div>
              <div className="d-flex justify-content-between">
                <span>{r.amount} {r.currency}</span>
                <span>{r.points} pts</span>
              </div>
              <div className="small text-muted mt-1">{r.created_at}</div>
            </CardBody>
          </Card>
        ))
      )}
    </Container>
  );
};

export default TransactionHistoryPage;
