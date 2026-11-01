import React from "react";
import { CheckCircle, XCircle } from "phosphor-react";
import { BookPlan } from "@/lib/api";

interface ComparePricingProps {
  plans: BookPlan[];
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

const ComparePricing: React.FC<ComparePricingProps> = ({ plans }) => {
  const featureList = [
    {
      label: 'Plan Name',
      value: (plan: BookPlan) => plan.name,
    },
    {
      label: 'Point Count',
      value: (plan: BookPlan) =>
        `${plan.points} point${plan.points === 1 ? '' : 's'}`,
    },
    {
      label: 'Total Cost',
      value: (plan: BookPlan) => formatMoney(plan.price, plan.currency),
    },
    {
      label: 'Ideal For',
      value: (plan: BookPlan) => plan.description || '—',
    },
    {
      label: 'Key Included Features',
      value: (plan: BookPlan) =>
        (plan.features ?? []).join(', ') || '—',
    },
  ];

  if (!plans.length) {
    return (
      <div className="text-center py-4 text-muted">
        No point packages available right now.
      </div>
    );
  }

  return (
    <div className="pricing-table table-responsive">
      <table className="table table-bottom-border table-striped align-middle text-center">
        <thead>
          <tr>
            <th></th>
            {plans.map((plan) => (
              <th key={plan.id}>{plan.name}</th>
            ))}
          </tr>
        </thead>
        <tbody>
          {featureList.map((feature, featureIndex) => (
            <tr key={featureIndex}>
              <th scope="row" className="text-start f-w-500">
                {feature.label}
              </th>
              {plans.map((plan) => {
                const value = feature.value(plan);

                return (
                  <td key={plan.id}>
                    {value === "check" ? (
                      <CheckCircle
                        size={20}
                        weight="duotone"
                        className="text-success"
                      />
                    ) : value === "x" ? (
                      <XCircle
                        size={20}
                        weight="duotone"
                        className="text-danger"
                      />
                    ) : (
                      <span className="f-w-600">{value}</span>
                    )}
                  </td>
                );
              })}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default ComparePricing;
