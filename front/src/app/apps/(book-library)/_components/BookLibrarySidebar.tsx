"use client";
import React, { useEffect, useState } from "react";
import { Card, CardBody, CardHeader } from "reactstrap";
import {
  IconBook,
  IconHelp,
  IconRotateClockwise2,
} from "@tabler/icons-react";
import { Files, Image } from "phosphor-react";
import { FileArchive, Video } from "@phosphor-icons/react";
import Loading from "@/app/loading";

type BookLibrarySidebarProps = {
  activeTab: string;
  setActiveTab: (tab: string) => void;
};

const bookCategories = [
  { label: "E-Books", icon: <Image size={18} weight="duotone" />, colorClass: "text-light-primary", files: "1.195 Files", size: "37.2GB" },
  { label: "Audiobooks", icon: <Video size={18} weight="duotone" />, colorClass: "text-light-success", files: "53 Files", size: "19.1 GB" },
  { label: "Documents", icon: <FileArchive size={18} weight="duotone" />, colorClass: "text-light-danger", files: "486 Files", size: "23.5 MB" },
  { label: "Others", icon: <Files size={18} weight="duotone" />, colorClass: "text-light-warning", files: "32 Files", size: "13 MB" },
];

const BookLibrarySidebar: React.FC<BookLibrarySidebarProps> = ({ activeTab, setActiveTab }) => {
  const handleTabClick = (tab: string) => setActiveTab(tab);
  const [ApexCharts, setApexCharts] = useState<any>(null);

  useEffect(() => {
    const loadModules = async () => {
      const [chartModule] = await Promise.all([import("react-apexcharts")]);
      setApexCharts(() => chartModule.default || chartModule);
    };
    if (typeof window !== "undefined") loadModules();
  }, []);

  return (
    <>
      <Card>
        <CardHeader>
          <h5>My Books</h5>
        </CardHeader>
        <CardBody>
          <div className="horizontal-tab-wrapper">
            <ul className="filemenu-list mt-3 tabs">
              <li className={`tab-link align-items-center ${activeTab === "1" ? "active" : ""}`} onClick={() => handleTabClick("1")} data-tab="1">
                <IconBook size={30} className=" pe-2" />
                <span className="flex-grow-1">Library</span>
                10+
              </li>
              <li className={`tab-link align-items-center ${activeTab === "4" ? "active" : ""}`} onClick={() => handleTabClick("4")} data-tab="4">
                <IconRotateClockwise2 size={28} className=" pe-2" />
                <span className="flex-grow-1">Recent</span>
              </li>
              <div className="app-divider-v dashed m-0 p-2"></div>
              <li className="tab-link align-items-center" onClick={() => handleTabClick("6")}>
                <IconHelp size={28} className=" pe-2" />
                <span className="flex-grow-1">Help</span>
              </li>
            </ul>
          </div>
        </CardBody>
      </Card>
      <Card>
        <CardHeader>
          <h5>Overview</h5>
        </CardHeader>
        <CardBody>
          <div className="mb-3">
            {ApexCharts ? (
              <ApexCharts series={[70]} type={"radialBar"} height={350} options={{
                chart: { offsetY: -20, sparkline: { enabled: true } },
                colors: ["rgba(var(--primary),1)"],
                plotOptions: { radialBar: { startAngle: -90, endAngle: 90, track: { background: "#e7e7e7", strokeWidth: "97%", margin: 5, dropShadow: { enabled: true, top: 2, left: 0, color: "#999", opacity: 1, blur: 2 } }, dataLabels: { name: { show: false }, value: { offsetY: -4, fontSize: "22px" } } } },
                grid: { padding: { top: -20 } },
                fill: { type: "", gradient: { shade: "", shadeIntensity: 0.4, inverseColors: false, opacityFrom: 1, opacityTo: 1, stops: [0, 60, 73, 108] } },
                labels: ["Average Results"],
              }} />
            ) : <Loading />}
          </div>
          {bookCategories.map((category, index) => (
            <div className="file-manager-sidebar mb-4" key={index}>
              <div className="d-flex align-items-center position-relative">
                <span className={`${category.colorClass} h-40 w-40 d-flex-center b-r-10 position-absolute`}>{category.icon}</span>
                <div className="flex-grow-1 ms-5">
                  <h6 className="mb-0">{category.label}</h6>
                  <p className="text-secondary mb-0">{category.files}</p>
                </div>
                <p className="text-secondary f-w-500 mb-0">{category.size}</p>
              </div>
            </div>
          ))}
        </CardBody>
      </Card>
    </>
  );
};

export default BookLibrarySidebar;
