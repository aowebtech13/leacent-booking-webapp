import React, { useEffect, useState } from "react";
import Image from "next/image";
import {
  EcommerceOverviewReport,
  EcommerceSaleReport,
} from "@/Data/Charts/ApexCharts/ApexChart";
import {
  Col,
  Card,
  CardBody,
  Dropdown,
  DropdownMenu,
  DropdownItem,
  Form,
} from "reactstrap";
import { AlignLeft, Calendar, CreditCards, DollarCircle } from "iconoir-react";
import { IconChevronDown } from "@tabler/icons-react";
import {
  getCategories,
  Category,
  getLatestBookPlanTransaction,
} from "@/lib/api/books";

const EcommerceSale = () => {
  const [Chart, setChart] = useState<any>(null);
  const [overviewDropdownOpen, setOverviewDropdownOpen] = useState(false);
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
        if (!cancelled) setProductCategories(categories);
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

  const [dropdownOpen, setDropdownOpen] = useState(false);

  const toggleDropdown = () => setDropdownOpen(!dropdownOpen);
  const toggleOverviewDropdown = () =>
    setOverviewDropdownOpen(!overviewDropdownOpen);
  return (
    <>
      <Col md={6} xxl={3}>
        <div className="p-3">
          <h5>Sale Report</h5>
        </div>

        <Card>
          <CardBody>
            <div>
              {Chart ? (
                <Chart
                  options={EcommerceSaleReport}
                  series={EcommerceSaleReport.series}
                  type="donut"
                  height={285}
                />
              ) : (
                <div>Loading Chart...</div>
              )}
            </div>
          </CardBody>
        </Card>
      </Col>
      <Col md={6} xxl={3}>
        <div className="p-3">
          <h5>Product Category</h5>
        </div>
        <Card className="product-category-card">
          <CardBody>
            <div className="d-flex justify-content-between align-items-center">
              <Dropdown isOpen={dropdownOpen} toggle={toggleDropdown}>
                <button
                  className="btn btn-link text-dark text-decoration-none p-0 border-0 text-dark"
                  role="button"
                >
                  <AlignLeft
                    width={20}
                    height={20}
                    className="f-s-20 f-w-600 text-dark-dark"
                  />
                  <IconChevronDown
                    size={18}
                    className="ms-1 f-s-18 align-top"
                  />
                </button>
                <DropdownMenu end>
                  <DropdownItem>Last Month</DropdownItem>
                  <DropdownItem>Last Week</DropdownItem>
                  <DropdownItem>Last Year</DropdownItem>
                </DropdownMenu>
              </Dropdown>

              <Form className="app-form">
                <select
                  aria-label="Default select example"
                  className="form-select custom-form-select"
                  defaultValue="1"
                >
                  <option>Filter</option>

                  <option value="2">Books</option>
                </select>
              </Form>
            </div>

            <ul className="product-category-list mt-3">
              {categoriesLoading ? (
                <li className="text-muted py-3">Loading categories…</li>
              ) : categoriesError ? (
                <li className="text-danger py-3">{categoriesError}</li>
              ) : productCategories.length === 0 ? (
                <li className="text-muted py-3">No categories available.</li>
              ) : (
                productCategories.map((category) => (
                  <li key={category.id} className="bg-light border-bottom">
                    <div>
                      <h6 className="text-dark mb-0">{category.name}</h6>
                      {category.description && (
                        <p className="text-muted small mb-0">
                          {category.description}
                        </p>
                      )}
                    </div>
                    <div className="text-dark f-w-600 ms-2 flex-shrink-0">
                      <span className={`badge bg-white-300 text-dark f-w-700`}>
                        {category.products_count ?? 0} products
                      </span>
                    </div>
                  </li>
                ))
              )}
            </ul>
          </CardBody>
        </Card>
      </Col>
      <Col md={6} xxl={3}>
        <div className="p-3">
          <h5>Overview</h5>
        </div>
        <Card>
          <CardBody>
            <div>
              {Chart ? (
                <Chart
                  options={EcommerceOverviewReport}
                  series={EcommerceOverviewReport.series}
                  type="bar"
                  height={240}
                />
              ) : (
                <div>Loading Chart...</div>
              )}
            </div>
            <div className="d-flex justify-content-between align-items-center">
              <Dropdown
                isOpen={overviewDropdownOpen}
                toggle={toggleOverviewDropdown}
              >
                <button
                  aria-expanded="false"
                  className="btn btn-link text-dark text-decoration-none p-0 border-0"
                  role="button"
                >
                  <AlignLeft
                    height={20}
                    width={20}
                    className="f-s-20 f-w-600 text-dark-dark"
                  />
                  <IconChevronDown
                    size={20}
                    className="ms-1 f-s-18 align-top"
                  />
                </button>
                <DropdownMenu end>
                  <DropdownItem>Last Month</DropdownItem>
                  <DropdownItem>Last Week</DropdownItem>
                  <DropdownItem>Last Year</DropdownItem>
                </DropdownMenu>
              </Dropdown>

              <Form className="app-form">
                <select
                  aria-label="Default select example"
                  className="form-select custom-form-select"
                  defaultValue="1"
                >
                  <option>Jan</option>
                  <option value="1">Feb</option>
                  <option value="2">Mar</option>
                  <option value="3">..</option>
                  <option value="4">Dec</option>
                </select>
              </Form>
            </div>
          </CardBody>
        </Card>
      </Col>
      <Col md={6} xxl={3}>
        <div className="p-3">
          <h5>Transaction</h5>
        </div>
        <Card className="transaction-card">
          <CardBody>
            <div className="text-center">
              <Image
                alt="logo-img"
                src="/images/form/done.png"
                width={64}
                height={64}
              />
              <h6 className="text-success-dark mb-0">Thank You!</h6>
              <p className="mb-0 f-w-600 text-success d-inline transaction-txt">
                Your transaction was successful
              </p>
              <Image
                alt="gif"
                className="w-30 d-inline align-text-bottom"
                src="/images/dashboard/ecommerce-dashboard/celebration.gif"
                width={100}
                height={100}
              />
            </div>

            <div className="custom-divider"></div>

            {transactionLoading ? (
              <div className="text-center py-4 text-muted">
                Loading transaction…
              </div>
            ) : !latestTransaction ? (
              <div className="text-center py-4 text-muted">
                No recent book-plan transaction.
              </div>
            ) : (
              <>
                <div className="d-flex justify-content-between">
                  <div>
                    <p className="text-dark f-w-500 mb-0">
                      <CreditCards
                        height={20}
                        width={20}
                        className="f-s-16 align-text-top me-2"
                      />
                      Transaction ID
                    </p>
                    <h6 className="text-success-dark">
                      {latestTransaction.payment_reference ||
                        latestTransaction.flutterwave_tx_ref ||
                        "—"}
                    </h6>
                  </div>
                  <div>
                    <p className="text-dark f-w-500 mb-0">
                      <DollarCircle
                        height={20}
                        width={20}
                        className="f-s-16 align-text-top me-2"
                      />
                      Amount
                    </p>
                    <h6 className="text-success-dark">
                      {latestTransaction.currency || "NGN"}{" "}
                      {Number(latestTransaction.amount ?? 0).toLocaleString()}
                    </h6>
                  </div>
                </div>

                <div className="mt-3">
                  <p className="text-dark f-w-500 mb-0">
                    <Calendar
                      height={20}
                      width={20}
                      className="f-s-16 align-text-top me-2"
                    />
                    Date &amp; Time
                  </p>
                  <h6 className="mb-0 text-success-dark">
                    {latestTransaction.paid_at
                      ? new Date(latestTransaction.paid_at).toLocaleString()
                      : "—"}
                  </h6>
                </div>

                {latestTransaction.bookPlan && (
                  <div className="mt-3 pt-3 border-top">
                    <p className="text-dark f-w-500 mb-1 text-sm">Book plan</p>
                    <h6 className="mb-0 text-dark">
                      {latestTransaction.bookPlan.name}
                    </h6>
                  </div>
                )}
              </>
            )}
          </CardBody>
        </Card>
      </Col>
    </>
  );
};

export default EcommerceSale;
