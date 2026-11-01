"use client";
import React, { useEffect, useState } from "react";
import { Card, CardHeader, CardBody } from "reactstrap";
import api from "@/lib/api/client";

interface DaysSinceRegistration {
  days_since_registration: number;
  registered_at: string;
}

const TimeSpent = () => {
  const [days, setDays] = useState<number | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    let cancelled = false;
    const load = async () => {
      setLoading(true);
      try {
        const res = await api.get("profile/days-since-registration");
        const data = res.data?.data as DaysSinceRegistration | undefined;
        if (!cancelled && data) setDays(data.days_since_registration);
      } catch {
        if (!cancelled) setDays(null);
      } finally {
        if (!cancelled) setLoading(false);
      }
    };
    load();
    return () => {
      cancelled = true;
    };
  }, []);

  return (
    <Card>
      <CardHeader>
        <h5>Time Spent</h5>
      </CardHeader>
      <CardBody>
        {loading ? (
          <p className="text-muted mb-0">Loading…</p>
        ) : days !== null ? (
          <div>
            <h4 className="mb-0 text-primary">{days}</h4>
            <p className="mb-0 text-muted">
              day{days === 1 ? "" : "s"} since you joined leacent
            </p>
          </div>
        ) : (
          <p className="text-muted mb-0">Unable to load registration date.</p>
        )}
      </CardBody>
    </Card>
  );
};

export default TimeSpent;