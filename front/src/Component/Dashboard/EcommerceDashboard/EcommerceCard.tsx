import React, { useEffect, useState } from "react";
import { Row, Col, Card, CardBody } from "reactstrap";
import { EcommerceChartData } from "@/Data/Charts/ApexCharts/ApexChart";
import { ArrowRight, Calendar } from "iconoir-react";
import Link from "next/link";
import { getBooksTotal, BookTotalResponse } from "@/lib/api/books";

const EcommerceCard = () => {
  const [Chart, setChart] = useState<any>(null);
  const [booksTotal, setBooksTotal] = useState<BookTotalResponse | null>(null);
  const [booksTotalLoading, setBooksTotalLoading] = useState(true);

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

  return (
    <>
      <Col sm="6" lg="4" xxl="2" className="order--1-lg">
        <Row>
          <Col xs="12">
            <Card className="orders-provided-card">
              <CardBody>
                <i className="ph-bold ph-circle circle-bg-img"></i>
                <div>
                  <p className="f-s-18 f-w-600 text-dark txt-ellipsis-1">
                    📈 leacent Book Points
                  </p>
                    <h2 className="text-secondary-dark mb-0">
                      {booksTotalLoading
                        ? "..."
                        : (booksTotal?.total ?? 0).toLocaleString()}
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
                  <p className="text-dark f-w-600 mb-0 mt-2 txt-ellipsis-1">
                    <Calendar
                      height={16}
                      width={16}
                      className="f-s-16 align-text-top me-2"
                    />
                    Oct 1 - Oct 15, 2024
                  </p>
                </div>
                <div className="my-4">
                  <h4 className="text-primary-dark">Name of Book</h4>
                </div>
                <div className="custom-progress-container">
                  <div className="progress-bar productive"></div>
                  <div className="progress-bar middle"></div>
                  <div className="progress-bar idle"></div>
                </div>
                <div className="progress-labels">
                  <span>25 %</span>
                  <span>45%</span>
                  <span>100%</span>
                </div>
              </CardBody>
            </Card>
          </Col>
        </Row>
      </Col>
      <Col sm="6" lg="4" xxl="2" className="order--1-lg">
        <Row>
          <Col xs="12">
            <Card className="bg-danger-300 product-sold-card">
              <CardBody>
                <div>
                  <h5 className="text-danger-dark f-w-600">Books Read</h5>
                  {Chart ? (
                    <Chart
                      options={EcommerceChartData}
                      series={EcommerceChartData.series}
                      type="line"
                      height={75}
                    />
                  ) : (
                    <div>Loading Chart...</div>
                  )}
                </div>
                <div>
                  <h4>$6.56k</h4>
                  <p className="mb-0 text-dark f-w-500 txt-ellipsis-1">
                    Last Week
                    <span
                      color="white"
                      className="badge bg-white-300 text-danger-dark ms-2"
                    >
                      -45%
                    </span>
                  </p>
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
                  <p className="text-success f-s-18 f-w-600 txt-ellipsis-1">
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
