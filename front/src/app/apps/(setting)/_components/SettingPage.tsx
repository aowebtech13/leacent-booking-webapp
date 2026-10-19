"use client";
import React, { useState } from "react";
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
import Link from "next/link";
import {
  Alarm,
  ArrowSquareOut,
  BellSimple,
  Graph,
  LockOpen,
  Notification,
  ShieldCheck,
  Trash,
  UserCircleGear,
} from "phosphor-react";



import SettingProfile from "@/app/apps/(setting)/_components/SettingProfile";
import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";
import TimeSpent from "./TimeSpent";
import { IconStack2 } from "@tabler/icons-react";

const Setting = () => {
  const [activeTab, setActiveTab] = useState("1");

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
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      });

      if (result.isConfirmed) {
        await Swal.fire("Deleted!", "Your file has been deleted.", "success");
      }
    }
  };

  return (
    <>
      <div className="container-fluid">
        <Breadcrumbs
          mainTitle="Setting"
          title=""
          path={["Complete Pofile", ""]}
          Icon={IconStack2}
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
                       My  Profile
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

            {/* Used Space Card */}
            <Card className="mb-4">
              <CardBody>
                <Card className="hover-effect card-light-primary mt-4">
                  <CardBody>
                    <h5>Used Space</h5>
                    <p className="mt-2 text-secondary fs-6">
                      Your team has used 80% of your available space. Need more?
                    </p>
                    {/* Custom Progress Bar */}
                    <div
                      className="progress w-100 mt-3 mb-3"
                      role="progressbar"
                      aria-valuenow={78.5}
                      aria-valuemin={0}
                      aria-valuemax={100}
                    >
                      <div
                        className="progress-bar bg-primary progress-bar-striped"
                        style={{ width: "78.5%" }}
                      >
                        78.5%
                      </div>
                    </div>
                    <div>
                      <a href="#" className="me-3 text-secondary">
                        Dismiss
                      </a>
                      <a href="#" className="text-decoration-underline">
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
