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
          <h5>Book Reports</h5>
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
    
    
    
    </>
  );
};

export default EcommerceSale;
