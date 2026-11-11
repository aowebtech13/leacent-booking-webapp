import React, { useEffect, useState } from "react";
import { EcommerceOrderData } from "@/Data/Charts/ApexCharts/ApexChart";
import { Card, CardBody, Col } from "reactstrap";
import Slider from "react-slick";
import { Badge } from "reactstrap";
import Loading from "@/app/loading";
import { getOrders, Order } from "@/lib/api/orders";
import { getMyBookPlanPayments } from "@/lib/api/bookPlans";
import { useAuth } from "@/lib/contexts/AuthContext";

const getStatusInfo = (order: Order) => {
  const status = (order.status || "").toLowerCase();
  const paymentStatus = (order.payment_status || "").toLowerCase();

  if (status === "cancelled") {
    return {
      label: "Canceled",
      statusClass: "danger",
      badgeClass: "danger",
      description: "Your order was canceled.",
    };
  }
  if (status === "completed" || status === "paid") {
    return {
      label: "Delivered",
      statusClass: "success",
      badgeClass: "success",
      description: order.updated_at
        ? `Your order was delivered on ${new Date(order.updated_at).toLocaleDateString("en-US", { month: "long", day: "numeric", year: "numeric" })}.`
        : "Your order was delivered.",
    };
  }
  if (status === "shipped") {
    return {
      label: "Shipped",
      statusClass: "info",
      badgeClass: "info",
      description: order.updated_at
        ? `Your order has been shipped and will be delivered by ${new Date(order.updated_at).toLocaleDateString("en-US", { month: "long", day: "numeric", year: "numeric" })}.`
        : "Your order has been shipped.",
    };
  }
  if (status === "processing") {
    return {
      label: "Processing",
      statusClass: "warning",
      badgeClass: "warning",
      description: "Your order is being processed.",
    };
  }
  if (paymentStatus === "pending_verification") {
    return {
      label: "Pending",
      statusClass: "warning",
      badgeClass: "warning",
      description: "Your payment is pending verification.",
    };
  }
  return {
    label: "Pending",
    statusClass: "warning",
    badgeClass: "warning",
    description: "Your order is being processed.",
  };
};

const mapPaymentStatus = (status: string) => {
  const s = (status || "").toLowerCase();
  if (s === "active" || s === "verified" || s === "completed") {
    return { label: "Completed", statusClass: "success", badgeClass: "success" };
  }
  if (s === "pending" || s === "pending_verification") {
    return { label: "Pending", statusClass: "warning", badgeClass: "warning" };
  }
  if (s === "failed" || s === "rejected" || s === "refunded") {
    return { label: "Failed", statusClass: "danger", badgeClass: "danger" };
  }
  return { label: "Pending", statusClass: "warning", badgeClass: "warning" };
};

const EcommerceDetail = () => {
  const [ApexCharts, setApexCharts] = useState<any>(null);
  const [orders, setOrders] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);
  const { isAuthenticated, isLoading: authLoading } = useAuth();

  useEffect(() => {
    const loadModules = async () => {
      const [chartModule] = await Promise.all([import("react-apexcharts")]);

      setApexCharts(() => chartModule.default || chartModule);
    };

    if (typeof window !== "undefined") {
      loadModules();
    }
  }, []);

  useEffect(() => {
    let cancelled = false;
    const fetchOrders = async () => {
      if (authLoading) return;
      if (!isAuthenticated) {
        if (!cancelled) {
          setOrders([]);
          setLoading(false);
        }
        return;
      }
      setLoading(true);
      try {
        const [orderRes, paymentRes] = await Promise.all([
          getOrders({ per_page: 6 }),
          getMyBookPlanPayments(),
        ]);

        const orderData = (orderRes as any)?.data ?? orderRes ?? [];
        const orderList = Array.isArray(orderData)
          ? orderData
          : (orderData?.data ?? []);

        const payments = Array.isArray(paymentRes)
          ? paymentRes
          : [];

        const mappedOrders = orderList.slice(0, 6).map((order: Order) => {
          const info = getStatusInfo(order);
          const dateStr = order.created_at
            ? new Date(order.created_at).toLocaleDateString("en-US", {
                month: "long",
                day: "numeric",
                year: "numeric",
              })
            : "";
          return {
            id: order.id,
            status: info.label,
            date: dateStr,
            statusClass: info.statusClass,
            badgeClass: info.badgeClass,
            description: info.description,
            type: "order" as const,
          };
        });

        const mappedPayments = payments.slice(0, 6).map((payment: any) => {
          const info = mapPaymentStatus(payment.status);
          const dateStr = payment.created_at
            ? new Date(payment.created_at).toLocaleDateString("en-US", {
                month: "long",
                day: "numeric",
                year: "numeric",
              })
            : "";
          return {
            id: payment.id,
            status: info.label,
            date: dateStr,
            statusClass: info.statusClass,
            badgeClass: info.badgeClass,
            description:
              payment.notes ||
              `Payment of ${payment.amount ?? 0} ${payment.currency ?? ""}`,
            type: "payment" as const,
          };
        });

        if (!cancelled) {
          setOrders([...mappedOrders, ...mappedPayments]);
        }
      } catch (err) {
        if (!cancelled) setOrders([]);
      } finally {
        if (!cancelled) setLoading(false);
      }
    };
    fetchOrders();
    return () => {
      cancelled = true;
    };
  }, [isAuthenticated, authLoading]);

  const settings = {
    dots: false,
    speed: 1000,
    slidesToShow: 3,
    arrows: false,
    vertical: true,
    verticalSwiping: true,
    focusOnSelect: true,
    autoplay: true,
    autoplaySpeed: 1000,
  };
  return (
    <>
      <Col md={8} lg={6} xl={5} className="ms-auto">
        <Card>
          <CardBody className="p-0">
            <div>
              {ApexCharts ? (
                <ApexCharts
                  options={EcommerceOrderData}
                  series={EcommerceOrderData.series}
                  type="bar"
                  height={324}
                />
              ) : (
                <Loading />
              )}
            </div>
          </CardBody>
        </Card>
      </Col>
      <Col className="d-md-none order--1-lg" md="5" lg="4" xxl="3">
        {!loading ? (
          <Card className="order-detail-card">
            <div className="pt-3">
              <h5 className="pa-s-20">Purchase History</h5>
            </div>
            <CardBody>
              <Slider {...settings}>
                {(orders).map((order) => (
                  <ul key={order.id} className="order-content-list">
                    <li className={`bg-${order.statusClass}-300`}>
                      <div className="d-flex align-items-center justify-content-between">
                        <h6
                          className={`text-${order.statusClass}-dark f-w-600 mb-0`}
                        >
                          {" "}
                          📦#{order.id}
                        </h6>
                        <Badge
                          color={`light-${order.statusClass}`}
                          className={`me-2 text-${order.statusClass}-dark`}
                        >
                          {order.status}
                        </Badge>
                      </div>
                      <div>
                        <p
                          className={`text-${order.statusClass} mb-0 txt-ellipsis-2`}
                        >
                          {order.description}
                        </p>
                      </div>
                      {order.status === "Canceled" && order.date && (
                        <p
                          className={`text-${order.statusClass}-dark f-w-600 mb-0 txt-ellipsis-1`}
                        >
                          <span className="f-w-600">Date Ordered</span>:{" "}
                          {order.date}
                        </p>
                      )}
                    </li>
                  </ul>
                ))}
                {!loading && orders.length === 0 && (
                  <ul className="order-content-list">
                    <li className="bg-light">
                      <div className="text-center text-muted py-3">
                        No orders found
                      </div>
                    </li>
                  </ul>
                )}
              </Slider>
            </CardBody>
          </Card>
        ) : null}
      </Col>
    </>
  );
};

export default EcommerceDetail;
