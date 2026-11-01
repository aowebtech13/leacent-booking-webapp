import React, { useEffect, useMemo, useState } from "react";
import { Row, Col, Card, CardBody } from "reactstrap";
import { EcommerceChartData } from "@/Data/Charts/ApexCharts/ApexChart";
import { ArrowRight, Calendar } from "iconoir-react";
import Link from "next/link";
import {
  getBooksTotal,
  getBooksSpending,
  getLatestReadingProgress,
  getPointsBalance,
  getPointsSpent,
  BookTotalResponse,
  BooksSpendingResponse,
  LatestReadingProgress,
  PointsBalanceResponse,
  PointsSpentResponse,
} from "@/lib/api/books";

const formatMoney = (amount: number, currency?: string) => {
  const value = Number.isFinite(amount) ? amount : 0;

  if (!currency) {
    return value.toLocaleString(undefined, { maximumFractionDigits: 2 });
  }

  try {
    return new Intl.NumberFormat("en-NG", {
      style: "currency",
      currency,
      maximumFractionDigits: Number.isInteger(value) ? 0 : 2,
    }).format(value);
  } catch {
    return `${currency} ${value.toLocaleString(undefined, {
      maximumFractionDigits: 2,
    })}`;
  }
};

const EcommerceCard = () => {
  const [Chart, setChart] = useState<any>(null);
  const [booksTotal, setBooksTotal] = useState<BookTotalResponse | null>(null);
  const [booksTotalLoading, setBooksTotalLoading] = useState(true);
  const [spending, setSpending] = useState<BooksSpendingResponse | null>(null);
  const [readingProgress, setReadingProgress] = useState<LatestReadingProgress | null>(null);
  const [readingProgressLoading, setReadingProgressLoading] = useState(true);
  const [pointsBalance, setPointsBalance] = useState<PointsBalanceResponse | null>(null);
  const [pointsBalanceLoading, setPointsBalanceLoading] = useState(true);
  const [pointsSpent, setPointsSpent] = useState<PointsSpentResponse | null>(null);
  const [pointsSpentLoading, setPointsSpentLoading] = useState(true);

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
    const loadBooksTotal = async () => {
      setBooksTotalLoading(true);
      try {
        const data = await getBooksTotal();
        if (!cancelled) setBooksTotal(data);
      } catch {
        if (!cancelled) setBooksTotal(null);
      } finally {
        if (!cancelled) setBooksTotalLoading(false);
      }
    };
    loadBooksTotal();
    return () => {
      cancelled = true;
    };
  }, []);

  useEffect(() => {
    let cancelled = false;
    const loadSpending = async () => {
      try {
        const data = await getBooksSpending();
        if (!cancelled) setSpending(data);
      } catch {
        if (!cancelled) setSpending(null);
      } finally {
      }
    };
    loadSpending();
    return () => {
      cancelled = true;
    };
  }, []);

  useEffect(() => {
    let cancelled = false;
    const loadReadingProgress = async () => {
      setReadingProgressLoading(true);
      try {
        const data = await getLatestReadingProgress();
        if (!cancelled) setReadingProgress(data);
      } catch {
        if (!cancelled) setReadingProgress(null);
      } finally {
        if (!cancelled) setReadingProgressLoading(false);
      }
    };
    loadReadingProgress();
    return () => {
      cancelled = true;
    };
  }, []);

  useEffect(() => {
    let cancelled = false;
    const loadPointsBalance = async () => {
      setPointsBalanceLoading(true);
      try {
        const data = await getPointsBalance();
        if (!cancelled) setPointsBalance(data);
      } catch {
        if (!cancelled) setPointsBalance(null);
      } finally {
        if (!cancelled) setPointsBalanceLoading(false);
      }
    };
    loadPointsBalance();
    return () => {
      cancelled = true;
    };
  }, []);

  useEffect(() => {
    let cancelled = false;
    const loadPointsSpent = async () => {
      setPointsSpentLoading(true);
      try {
        const data = await getPointsSpent();
        if (!cancelled) setPointsSpent(data);
      } catch {
        if (!cancelled) setPointsSpent(null);
      } finally {
        if (!cancelled) setPointsSpentLoading(false);
      }
    };
    loadPointsSpent();
    return () => {
      cancelled = true;
    };
  }, []);

  const progressPercent = readingProgress?.progress_percentage ?? 0;
  const hasRead = !!readingProgress;

  const spendingChartOptions = useMemo(() => {
    const points = spending?.series ?? [];
    const values = points.map((point) => point.amount);
    const peak = values.length ? Math.max(...values) : 0;
    const base = EcommerceChartData as any;

    return {
      ...base,
      series: [{ name: "Points Spent", data: values }],
      xaxis: {
        ...base.xaxis,
        categories: points.map((point) => point.date),
      },
      yaxis: {
        ...base.yaxis,
        min: 0,
        max: peak > 0 ? peak * 1.2 : 1,
      },
      tooltip: {
        ...base.tooltip,
        x: { show: true },
        y: {
          formatter: (value: number) => formatMoney(value, spending?.currency),
        },
      },
    };
  }, [spending]);

  return (
    <>
      <Col sm="12" lg="6" xl="4" xxl="3" className="order--1-lg">
        <Row>
          <Col xs="12">
            <Card className="orders-provided-card">
              <CardBody>
                <i className="ph-bold ph-circle circle-bg-img"></i>
                <div>
                  <p className="f-s-18 f-w-600 text-dark">
                    📈 leacent Book Points
                  </p>
                  <h2 className="text-secondary-dark mb-0">
                    {pointsBalanceLoading
                      ? "..."
                      : (pointsBalance?.points ?? 0).toLocaleString()}
                  </h2>
                </div>
              </CardBody>
            </Card>
          </Col>
          <Col xs="12">
            <Card className="bg-primary-300 product-sold-card">
              <CardBody>
                <div>
                  <h5 className="text-primary-dark f-w-600">Book Progress</h5>
                  {readingProgressLoading ? (
                    <p className="text-dark f-w-600 mb-0 mt-2">
                      <Calendar
                        height={16}
                        width={16}
                        className="f-s-16 align-text-top me-2"
                      />
                      Loading…
                    </p>
                  ) : hasRead ? (
                    <p className="text-dark f-w-600 mb-0 mt-2">
                      <Calendar
                        height={16}
                        width={16}
                        className="f-s-16 align-text-top me-2"
                      />
                      {readingProgress.range_start} - {readingProgress.range_end}
                    </p>
                  ) : (
                    <p className="text-dark f-w-600 mb-0 mt-2">
                      <Calendar
                        height={16}
                        width={16}
                        className="f-s-16 align-text-top me-2"
                      />
                      You haven't read any book yet
                    </p>
                  )}
                </div>
                <div className="my-4">
                  <h4 className="text-primary-dark">
                    {readingProgressLoading
                      ? "..."
                      : hasRead
                        ? readingProgress.book_title
                        : "No books yet"}
                  </h4>
                </div>
                <div className="custom-progress-container">
                  <div
                    className="progress-bar productive"
                    style={{ width: `${progressPercent}%` }}
                  ></div>
                  <div className="progress-bar middle"></div>
                  <div className="progress-bar idle"></div>
                </div>
                <div className="progress-labels">
                  <span>{progressPercent} %</span>
                  <span>45%</span>
                  <span>100%</span>
                </div>
              </CardBody>
            </Card>
          </Col>
        </Row>
      </Col>
      <Col sm="12" lg="6" xl="4" xxl="3" className="order--1-lg">
        <Row>
          <Col xs="12">
            <Card className="bg-danger-300 product-sold-card">
              <CardBody>
                <div>
                  <h5 className="text-danger-dark f-w-600">Point Spent</h5>
                  {Chart ? (
                    <Chart
                      options={spendingChartOptions}
                      series={spendingChartOptions.series}
                      type="line"
                      height={75}
                    />
                  ) : (
                    <div>Loading Chart...</div>
                  )}
                </div>
                <div>
                  <h4>
                    {pointsSpentLoading
                      ? "..."
                      : (pointsSpent?.points_spent ?? 0).toLocaleString()}
                  </h4>
                
                  {!pointsBalanceLoading && (pointsBalance?.points ?? 0) < 3 && (
                    <span className="badge bg-warning text-dark ms-2">
                      Low points
                    </span>
                  )}
                </div>
                <Link
                  className="bg-danger h-35 w-35 d-flex-center b-r-50 product-sold-icon"
                  href="/apps/e-shop/orders-details"
                  target="_blank"
                >
                  <ArrowRight
                    fontWeight="bold"
                    height={20}
                    width={20}
                    className="f-s-18 animate__pulse animate__fadeOutRight animate__infinite animate__slower"
                  />
                </Link>
              </CardBody>
            </Card>
          </Col>
          <Col xs="12">
            <Card className="product-store-card">
              <CardBody>
                <i className="ph-bold ph-circle circle-bg-img"></i>
                <div>
                  <p className="text-success f-s-18 f-w-600">
                    📝 Books in Store
                  </p>
                  <h2 className="text-success-dark mb-0">
                    {booksTotalLoading
                      ? "..."
                      : (booksTotal?.total ?? 0).toLocaleString()}
                  </h2>
                </div>
              </CardBody>
            </Card>
          </Col>
        </Row>
      </Col>
    </>
  );
};

export default EcommerceCard;
