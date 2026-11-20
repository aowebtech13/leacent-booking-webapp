"use client";

import React, { useEffect, useState } from "react";
import { Container, Row, Col, Card, CardBody, Button } from "reactstrap";
import { Check } from "phosphor-react";
import SectionHeading from "@/app/other-pages/(landing)/_components/SectionHeading";
import { getBookPlans, BookPlan } from "@/lib/api";

const DEFAULT_LOGO =
  "https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png";

const FALLBACK_FEATURES = [
  "6 Month support",
  "Single end product use",
  "Future upgrades included",
  "Free for use in end products",
];

interface DisplayPlan {
  title: string;
  price: string;
  badgeColor: string;
  image: string;
  description: string;
  features: string[];
  link: string;
  buttonColor: string;
  highlight: boolean;
}

function formatPrice(amount: number, currency?: string): string {
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
}

function toDisplayPlan(plan: BookPlan): DisplayPlan {
  const features = (plan.features ?? []).filter(Boolean);

  return {
    title: plan.name,
    price: formatPrice(plan.price, plan.currency),
    badgeColor: "primary",
    image: DEFAULT_LOGO,
    description:
      plan.description ||
      "Essential features at the best value. Get started today with our budget-friendly pricing!",
    features: features.length ? features : FALLBACK_FEATURES,
    link: "/apps/pricing",
    buttonColor: plan.is_featured ? "primary" : "dark",
    highlight: plan.is_featured,
  };
}

const PricingPlansSection = () => {
  const [plans, setPlans] = useState<DisplayPlan[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    let active = true;

    (async () => {
      try {
        const data = await getBookPlans();
        // Only the first two plans are shown on the landing page.
        const topTwo = (data ?? []).slice(0, 2).map(toDisplayPlan);
        if (active) setPlans(topTwo);
      } catch (err: any) {
        if (active) setError(err?.message || "Failed to load pricing plans");
      } finally {
        if (active) setLoading(false);
      }
    })();

    return () => {
      active = false;
    };
  }, []);

  return (
    <Container>
      <SectionHeading
        title="Purchase"
        highlight="Plans"
        description="Include information on how users can navigate your platform, select a plan, and complete the transaction."
      />

      {loading ? (
        <div className="text-center py-5 text-muted">Loading plans…</div>
      ) : error ? (
        <div className="text-center py-5 text-danger">{error}</div>
      ) : plans.length === 0 ? (
        <div className="text-center py-5 text-muted">
          No plans available right now.
        </div>
      ) : (
        <Row className="justify-content-center">
          {plans.map((plan, idx) => (
            <Col
              key={idx}
              md={6}
              xl={6}
            >
              <Card
                className={`pricing-cards mb-0 ${plan.highlight ? "active" : ""}`}
              >
                <CardBody className={plan.highlight ? "p-0" : ""}>
                  <Row className={plan.highlight ? "" : "align-items-center"}>
                    {!plan.highlight && (
                      <Col md={5} xl={6}>
                        <div>
                          <img
                            src={plan.image}
                            alt={plan.title}
                            className="w-120"
                          />
                        </div>
                        <p
                          className={`badge bg-${plan.badgeColor} f-s-16 mt-3`}
                        >
                          {plan.title}
                        </p>
                        <h1 className="text-dark f-w-700 mt-3">{plan.price}</h1>
                        <p className="text-secondary txt-ellipsis-3 f-w-500 f-s-16">
                          {plan.description}
                        </p>
                      </Col>
                    )}

                    <Col
                      md={plan.highlight ? 12 : 7}
                      xl={plan.highlight ? 12 : 6}
                    >
                      <div className="pricing-details">
                        <div className="price-title">
                          {!plan.highlight && (
                            <h3 className="text-dark f-w-600 txt-ellipsis-1">
                              {plan.title} List
                            </h3>
                          )}
                          {plan.highlight && (
                            <>
                              <p>{plan.title}</p>
                              <h2>{plan.price}</h2>
                            </>
                          )}
                          <ul className="pricing-list-menu">
                            {plan.features.map((feature, i) => (
                              <li
                                key={i}
                                className={`pricing-listitem ${
                                  plan.highlight ? "text-dark" : ""
                                }`}
                              >
                                <Check
                                  size={18}
                                  className="text-success me-2"
                                />
                                {feature}
                              </li>
                            ))}
                          </ul>
                          <div className="text-center price-btn">
                            <Button
                              href={plan.link}
                              color={plan.buttonColor}
                              size="lg"
                            >
                              Buy Plans
                            </Button>
                          </div>
                        </div>
                      </div>
                    </Col>
                  </Row>
                </CardBody>
              </Card>
            </Col>
          ))}
        </Row>
      )}
    </Container>
  );
};

export default PricingPlansSection;
