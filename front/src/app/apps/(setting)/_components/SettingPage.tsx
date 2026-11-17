"use client";
import React, { useEffect, useState } from "react";
import {
  Card,
  CardHeader,
  CardBody,
  Nav,
  NavItem,
  NavLink,
  TabContent,
  TabPane,
  Col,
  Row,
} from "reactstrap";
import { ArrowClockwise, UserCircleGear } from "phosphor-react";

import SettingProfile from "@/app/apps/(setting)/_components/SettingProfile";
import ChangePasswordForm from "@/app/apps/(setting)/_components/ChangePasswordForm";
import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";
import TimeSpent from "./TimeSpent";
import Link from "next/link";
import { IconStack2 } from "@tabler/icons-react";
import { useAuth } from "@/lib/contexts/AuthContext";
import { getDashboard } from "@/lib/api/books";

const Setting = () => {
  const { user, isAuthenticated } = useAuth();
  const [activeTab, setActiveTab] = useState("1");
  const [dashboard, setDashboard] = useState<DashboardResponse | null>(null);
  const [loading, setLoading] = useState(true);

  interface DashboardResponse {
    points_balance: number;
    points_spent: number;
    total_books: number;
    premium_books: number;
    free_books: number;
  }

  const toggleTab = (tab: string) => {
    if (activeTab !== tab) {
      setActiveTab(tab);
    }
  };

  useEffect(() => {
    let cancelled = false;
    const loadDashboard = async () => {
      setLoading(true);
      try {
        const data = await getDashboard();
        if (!cancelled) setDashboard(data);
      } catch {
        if (!cancelled) setDashboard(null);
      } finally {
        if (!cancelled) setLoading(false);
      }
    };
    if (isAuthenticated) {
      loadDashboard();
    } else {
      setLoading(false);
    }

    // Refresh the points shown here after a book unlock.
    const handlePointsUpdated = () => {
      if (isAuthenticated) loadDashboard();
    };
    window.addEventListener("leacent:points-updated", handlePointsUpdated);

    return () => {
      cancelled = true;
      window.removeEventListener("leacent:points-updated", handlePointsUpdated);
    };
  }, [isAuthenticated]);

  const username = user?.name ?? "there";
  const pointsLabel = loading
    ? "..."
    : (dashboard?.points_balance ?? 0).toLocaleString();
  const pointsSpentLabel = loading
    ? "..."
    : (dashboard?.points_spent ?? 0).toLocaleString();
  const totalBooksLabel = loading
    ? "..."
    : (dashboard?.total_books ?? 0).toLocaleString();

  return (
    <>
      <div className="container-fluid">
        <Breadcrumbs
          mainTitle="Setting"
          title=""
          path={["Complete Pofile", ""]}
          Icon={IconStack2 as any}
        />
        <Row className="row m-1">
          <Col lg={4} xxl={3}>
            <Card>
              <CardHeader>
                <h5>Settings</h5>
              </CardHeader>
              <CardBody>
                <div className="vertical-tab setting-tab">
                  <Nav tabs className="tab-light-primary">
                    <NavItem className="cursor-pointer">
                      <NavLink
                        className={`nav-link ${activeTab === "1" ? "active" : ""}`}
                        onClick={() => toggleTab("1")}
                      >
                        <UserCircleGear
                          weight="bold"
                          size={20}
                          className="me-2"
                        />
                        My Profile
                      </NavLink>
                    </NavItem>

                    <NavItem className="cursor-pointer">
                      <NavLink
                        className={`nav-link ${activeTab === "2" ? "active" : ""}`}
                        onClick={() => toggleTab("2")}
                      >
                        <ArrowClockwise
                          weight="bold"
                          size={20}
                          className="me-2"
                        />
                        Reset Password
                      </NavLink>
                    </NavItem>
                  </Nav>
                </div>
              </CardBody>
            </Card>

            <Card className="mb-4">
              <CardHeader>
                <h5>Time Spent</h5>
              </CardHeader>
              <CardBody>
                <TimeSpent />
              </CardBody>
            </Card>

            {/* Dashboard: Points Balance */}
            <Card className="mb-4">
              <CardBody>
                <Card className="hover-effect card-light-primary mt-4">
                  <CardBody>
                    <h5>Points Balance</h5>
                    <p className="mt-2 text-secondary fs-6">
                      Dear {username}, you have {pointsLabel} point
                      {pointsLabel === "1" ? "" : "s"} left. Upgrade now.
                    </p>
                    <div>
                      <Link
                        href="/apps/pricing"
                        className="text-decoration-underline"
                      >
                        Upgrade plan
                      </Link>
                    </div>
                  </CardBody>
                </Card>
              </CardBody>
            </Card>

            {/* Dashboard: Points Spent */}
            <Card className="mb-4">
              <CardBody>
                <Card className="hover-effect card-light-info mt-4">
                  <CardBody>
                    <h5>Points Spent on Books</h5>
                    <p className="mt-2 text-secondary fs-6">
                      You have spent {pointsSpentLabel} point
                      {pointsSpentLabel === "1" ? "" : "s"} unlocking books.
                    </p>
                  </CardBody>
                </Card>
              </CardBody>
            </Card>

            {/* Dashboard: Total Books in Store */}
            <Card className="mb-4">
              <CardBody>
                <Card className="hover-effect card-light-success mt-4">
                  <CardBody>
                    <h5>Books in Store</h5>
                    <p className="mt-2 text-secondary fs-6">
                      There are {totalBooksLabel} book
                      {totalBooksLabel === "1" ? "" : "s"} available in the
                      store.
                    </p>
                  </CardBody>
                </Card>
              </CardBody>
            </Card>
          </Col>
          <Col lg={8} xxl={9}>
            <TabContent activeTab={activeTab}>
              <TabPane tabId="1">
                <SettingProfile />
              </TabPane>
              <TabPane tabId="2">
                <ChangePasswordForm />
              </TabPane>
            </TabContent>
          </Col>
        </Row>
      </div>
    </>
  );
};

export default Setting;
