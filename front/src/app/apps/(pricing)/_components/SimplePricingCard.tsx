import React from "react";
import Slider from "react-slick";
import { Check } from "phosphor-react";
import { Button, Card, CardBody } from "reactstrap";
import { BookPlan } from "@/lib/api";

interface SimplePricingCardProps {
  plans: BookPlan[];
  loading?: boolean;
  onSubscribe: (plan: BookPlan) => void;
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

const periodLabel = (plan: BookPlan) => {
  if (plan.billing_cycle === "yearly") return "per year";
  if (plan.billing_cycle === "one_time") return "one time";
  return "per month";
};

const SimplePricingCard: React.FC<SimplePricingCardProps> = ({
  plans,
  loading = false,
  onSubscribe,
}) => {
  const slidesToShow = plans.length ? Math.min(4, plans.length) : 1;

  const sliderSettings = {
    infinite: true,
    slidesToShow,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 1440,
        settings: { slidesToShow: Math.min(3, slidesToShow) },
      },
      {
        breakpoint: 991,
        settings: { slidesToShow: Math.min(2, slidesToShow) },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          autoplay: true,
          autoplaySpeed: 2000,
        },
      },
    ],
  };

  return (
    <div className="simple-pricing-container">
      {loading ? (
        <div className="text-center py-4 text-muted">Loading plans…</div>
      ) : plans.length === 0 ? (
        <div className="text-center py-4 text-muted">
          No subscription plans available right now.
        </div>
      ) : (
        <Slider {...sliderSettings}>
          {plans.map((plan) => (
            <div key={plan.id} className="p-3">
              <Card className="simple-pricing-card">
                <CardBody>
                  <div className="simple-price-header text-center mb-3">
                    <h4 className="mb-0">{plan.name}</h4>
                    {plan.description && (
                      <p className="f-s-13 text-muted mt-1 mb-0">
                        {plan.description}
                      </p>
                    )}
                  </div>

                  <div className="simple-price-body">
                    <div
                      className={`simple-price-value text-center rounded bg-light-${
                        plan.is_featured ? "success" : "secondary"
                      } d-block py-3 mb-3`}
                    >
                      <span className="f-s-24 f-w-600 d-block">
                        {formatMoney(plan.price, plan.currency)}/
                      </span>
                      <span className="f-s-12 f-w-600">
                        {periodLabel(plan)}
                      </span>
                    </div>

                    <div className="simple-price-content">
                      {(plan.features ?? []).map((feature, i) => (
                        <div key={i}>
                          <div className="d-flex align-items-start mb-2">
                            <Check
                              size={20}
                              weight="duotone"
                              className="bg-success p-1 b-r-100"
                            />
                            <p className="ms-2 mb-0">{feature}</p>
                          </div>
                          <div className="app-divider-v px-2" />
                        </div>
                      ))}

                      <Button
                        color=""
                        className={`${
                          plan.is_featured ? "btn-success" : "btn-secondary"
                        } rounded w-100 p-2 mt-3`}
                        type="button"
                        onClick={() => onSubscribe(plan)}
                      >
                        Subscribe
                      </Button>
                    </div>
                  </div>
                </CardBody>
              </Card>
            </div>
          ))}
        </Slider>
      )}
    </div>
  );
};

export default SimplePricingCard;
