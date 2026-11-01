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
import { Trash, UserCircleGear } from "phosphor-react";

import SettingProfile from "@/app/apps/(setting)/_components/SettingProfile";
import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";
import TimeSpent from "./TimeSpent";
import { IconStack2 } from "@tabler/icons-react";
import { useAuth } from "@/lib/contexts/AuthContext";
import { getPointsBalance } from "@/lib/api/books";

const Setting = () => {
  const { user, isAuthenticated } = useAuth();
  const [activeTab, setActiveTab] = useState("1");
  const [points, setPoints] = useState<number | null>(null);
  const [pointsLoading, setPointsLoading] = useState(true);

  const toggleTab = (tab: string) => {
    if (activeTab !== tab) {
      setActiveTab(tab);
    }
  };

  const handleDeleteClick = async () => {
    if (typeof window !== "undefined") {
      const { default: Swal } = await import("sweetalert2");
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancel: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      });

      if (result.isConfirmed) {
        await Swal.fire("Deleted!", "Your file has been deleted.", "success");
      }
    }
  };

  useEffect(() => {
    let cancelled = false;
    const loadPoints = async () => {
      setPointsLoading(true);
      try {
        const data = await getPointsBalance();
        if (!cancelled) setPoints(data.points ?? 0);
      } catch {
        if (!cancelled) setPoints(null);
      } finally {
        if (!cancelled) setPointsLoading(false);
      }
    };
    if (isAuthenticated) {
      loadPoints();
    } else {
      setPointsLoading(false);
    }
    return () => {
      cancelled = true;
    };
  }, [isAuthenticated]);

  const username = user?.name ?? "there";
  const pointsLabel = pointsLoading ? "..." : (points ?? 0).toLocaleString();

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
                        className="nav-link"
                        id="account_delete"
                        onClick={handleDeleteClick}
                      >
                        <Trash weight="bold" size={20} className="me-2" />
                        Delete Account
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

            {/* Points Balance Card */}
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
                      <a
                        href="/apps/pricing"
                        className="text-decoration-underline"
                      >
                        Upgrade plan
                      </a>
                    </div>
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
            </TabContent>
          </Col>
        </Row>
      </div>
    </>
  );
};

export default Setting;
