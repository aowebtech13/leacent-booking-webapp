import React, { useEffect, useMemo, useState } from "react";
import { EcommerceSaleReport } from "@/Data/Charts/ApexCharts/ApexChart";
import { Col, Card, CardBody } from "reactstrap";
import {
  getCategories,
  Category,
  getLatestBookPlanTransaction,
} from "@/lib/api/books";

const formatMoney = (amount: number, currency?: string) => {
  const value = Number.isFinite(Number(amount)) ? Number(amount) : 0;

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

const EcommerceSale = () => {
  const [Chart, setChart] = useState<any>(null);
  const [productCategories, setProductCategories] = useState<Category[]>([]);
  const [categoriesLoading, setCategoriesLoading] = useState(true);
  const [categoriesError, setCategoriesError] = useState<string | null>(null);
  const [latestTransaction, setLatestTransaction] = useState<any>(null);
  const [transactionLoading, setTransactionLoading] = useState(true);

  useEffect(() => {
    const loadModules = async () => {
      const [chartModule] = await Promise.all([import("react-apexcharts")]);

      setChart(() => chartModule.default || chartModule);
    };

    if (typeof window !== "undefined") {
      loadModules();
    }
  }, []);

  useEffect(() => {
    let cancelled = false;
    const loadCategories = async () => {
      setCategoriesLoading(true);
      setCategoriesError(null);
      try {
        const categories = await getCategories();
        if (!cancelled) setProductCategories(categories ?? []);
      } catch (err: any) {
        if (!cancelled)
          setCategoriesError(err?.message || "Failed to load categories");
      } finally {
        if (!cancelled) setCategoriesLoading(false);
      }
    };
    loadCategories();
    return () => {
      cancelled = true;
    };
  }, []);

  useEffect(() => {
    let cancelled = false;
    const loadTransaction = async () => {
      setTransactionLoading(true);
      try {
        const payment = await getLatestBookPlanTransaction();
        if (!cancelled) setLatestTransaction(payment ?? null);
      } catch {
        if (!cancelled) setLatestTransaction(null);
      } finally {
        if (!cancelled) setTransactionLoading(false);
      }
    };
    loadTransaction();
    return () => {
      cancelled = true;
    };
  }, []);

  const chartOptions = useMemo(() => {
    if (!productCategories.length) {
      return EcommerceSaleReport;
    }

    return {
      ...EcommerceSaleReport,
      labels: productCategories.map((category) => category.name),
      series: productCategories.map((category) => category.products_count ?? 0),
    };
  }, [productCategories]);

  const transactionStatus = latestTransaction?.status ?? null;

  return (
    <>
      <Col md={6} xxl={3}>
        <div className="p-3">
          <h5>Book Reports</h5>
        </div>

        <Card>
          <CardBody>
            <div>
              {Chart ? (
                <Chart
                  options={chartOptions}
                  series={chartOptions.series}
                  type="donut"
                  height={285}
                />
              ) : (
                <div>Loading Chart...</div>
              )}
            </div>

            {categoriesError && (
              <p className="text-danger f-s-13 mb-0 mt-2">{categoriesError}</p>
            )}

            {categoriesLoading && !categoriesError && (
              <p className="text-muted f-s-13 mb-0 mt-2">Loading categories…</p>
            )}

            <div className="text-center mt-3">
              <p className="f-s-13 text-muted mb-1">Latest plan payment</p>
              {transactionLoading ? (
                <p className="f-s-13 text-muted mb-0">Loading…</p>
              ) : latestTransaction ? (
                <>
                  <h6 className="mb-1">
                    {formatMoney(
                      latestTransaction.amount,
                      latestTransaction.currency
                    )}
                  </h6>
                  <span
                    className={`badge bg-${
                      transactionStatus === "active"
                        ? "success"
                        : transactionStatus === "pending"
                          ? "warning"
                          : "danger"
                    }`}
                  >
                    {String(transactionStatus ?? "unknown")}
                  </span>
                </>
              ) : (
                <p className="f-s-13 text-muted mb-0">No plan payment yet</p>
              )}
            </div>
          </CardBody>
        </Card>
      </Col>
    </>
  );
};

export default EcommerceSale;
