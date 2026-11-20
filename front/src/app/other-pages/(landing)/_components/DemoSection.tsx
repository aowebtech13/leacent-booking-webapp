import React, { useState } from "react";
import {
  Row,
  Col,
  Button,
  Nav,
  NavItem,
  NavLink,
  TabPane,
} from "reactstrap";
import classnames from "classnames";

import { IconChevronsRight } from "@tabler/icons-react";
import SectionHeading from "@/app/other-pages/(landing)/_components/SectionHeading";

type DemoItem = {
  imgSrc: string;
  title: string;
  link: string;
  btnClass?: string;
  btnColor?: string;
};

const DemoSection: React.FC = () => {
  const [activeTab, setActiveTab] = useState<string>("dashboard");

  const toggle = (tab: string) => {
    if (activeTab !== tab) setActiveTab(tab);
  };

  return (
    <div>
      <div className="container-fluid">
        <SectionHeading
          title="pages"
          highlight="150+"
          description="All pages created with unlimited features that will reduce the
                cost, efforts and your time."
        />
        <Row>
          <Col xl={8} className="offset-xl-2">
            <div className="demos-tab-section">
              <Nav tabs className="app-tabs-dark" id="v-bg" role="tablist">
                {[
                  { id: "dashboard", icon: "ti-home", label: "Dashboard" },
                  { id: "apps", icon: "ti-server", label: "Apps" },
                  { id: "ui", icon: "ti-first-aid-kit", label: "UI Kits" },
                  {
                    id: "advance-ui",
                    icon: "ti-briefcase",
                    label: "Advance UI",
                  },
                  { id: "icons", icon: "ti-icons", label: "Icons" },
                  { id: "table", icon: "ti-table", label: "Tables" },
                  { id: "forms", icon: "ti-forms", label: "Forms" },
                  {
                    id: "ready-to-use",
                    icon: "ti-table-import",
                    label: "Ready To Use",
                  },
                  { id: "auth", icon: "ti-news", label: "Auth Pages" },
                  { id: "error", icon: "ti-news", label: "Error Pages" },
                ].map((tab) => (
                  <NavItem
                    key={tab.id}
                    role="presentation"
                    className="cursor-pointer"
                  >
                    <NavLink
                      className={classnames({
                        active: activeTab === tab.id,
                      })}
                      onClick={() => toggle(tab.id)}
                      role="tab"
                    >
                      <i className={`ti ${tab.icon} pe-2 ps-1`}></i> {tab.label}
                    </NavLink>
                  </NavItem>
                ))}
              </Nav>
            </div>
          </Col>
         
        </Row>
      </div>
    </div>
  );
};

export default DemoSection;
