import React, { useState } from "react";
import { Row, Col, Nav, NavItem, NavLink } from "reactstrap";
import classnames from "classnames";

import SectionHeading from "@/app/other-pages/(landing)/_components/SectionHeading";

const DemoSection: React.FC = () => {
  const [activeTab, setActiveTab] = useState<string>("dashboard");

  const toggle = (tab: string) => {
    if (activeTab !== tab) setActiveTab(tab);
  };

  return (
    <div>
      <div className="container-fluid">
        <SectionHeading
          title="20+"
          highlight="Books"
          description="Join the Business Lab Club and enjoy the business relationship we offer through our registered  members' Movement."
        />
        <Row>
          <Col xl={8} className="offset-xl-2">
            <div className="demos-tab-section">
              <Nav tabs className="app-tabs-dark" id="v-bg" role="tablist">
                {[
                  { id: "tab1", icon: "ti-home", label: "Dream Saboteurs" },
                  {
                    id: "tab2",
                    icon: "ti-server",
                    label: "Delicate Sweetness",
                  },
                  {
                    id: "tab3",
                    icon: "ti-first-aid-kit",
                    label: "Savvy Investors",
                  },
                  {
                    id: "tab4",
                    icon: "ti-briefcase",
                    label: "Investing in Stocks, Mutuals",
                  },
                  { id: "tab5", icon: "ti-icons", label: "Corporate Scuffle" },
                  {
                    id: "tab6",
                    icon: "ti-table",
                    label: "Desperate Business Partner",
                  },
                  { id: "tab7", icon: "ti-forms", label: "Baddest Schemer" },
                  {
                    id: "tab8",
                    icon: "ti-table-import",
                    label: "The Unreal Estate",
                  },
                  { id: "tab9", icon: "ti-news", label: "Mister President" },
                  { id: "tab10", icon: "ti-news", label: "Hey, Guys" },
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
