"use client";
import React, { useEffect, useState } from "react";
import { Card, CardBody, CardHeader } from "reactstrap";
import { IconBook, IconHelp, IconChevronRight } from "@tabler/icons-react";
import { Image } from "phosphor-react";
import { Video } from "@phosphor-icons/react";
import Loading from "@/app/loading";
import Link from "next/link";
import { getMyBooks } from "@/lib/api/books";

type BookLibrarySidebarProps = {
  activeTab: string;
  setActiveTab: (tab: string) => void;
};

const bookCategories = [
  {
    label: "Audiobooks",
    icon: <Video size={18} weight="duotone" />,
    colorClass: "text-light-success",
    files: "53 Files",
    size: "19.1 GB",
  },

];

const BookLibrarySidebar: React.FC<BookLibrarySidebarProps> = ({
  activeTab,
  setActiveTab,
}) => {
  const handleTabClick = (tab: string) => setActiveTab(tab);
  const [ApexCharts, setApexCharts] = useState<any>(null);
  const [unlockedCount, setUnlockedCount] = useState<number | null>(null);

  useEffect(() => {
    let cancelled = false;
    getMyBooks()
      .then((books) => {
        if (!cancelled) setUnlockedCount(books.length);
      })
      .catch(() => {
        // Not signed in or request failed — treat as no unlocked books.
        if (!cancelled) setUnlockedCount(0);
      });
    return () => {
      cancelled = true;
    };
  }, []);

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
              <li
                className={`tab-link align-items-center ${activeTab === "1" ? "active" : ""}`}
                onClick={() => handleTabClick("1")}
                data-tab="1"
              >
                <IconBook size={30} className=" pe-2" />
                <span className="flex-grow-1">Library</span>
                10+
              </li>
              <div className="app-divider-v dashed m-0 p-2"></div>
              <li className="tab-link align-items-center">
                <Link
                  href="/apps/contact"
                  className="d-flex align-items-center w-100 text-decoration-none text-reset"
                >
                  <IconHelp size={28} className=" pe-2" />
                  <span className="flex-grow-1">Help</span>
                </Link>
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
              <ApexCharts
                series={[70]}
                type={"radialBar"}
                height={350}
                options={{
                  chart: { offsetY: -20, sparkline: { enabled: true } },
                  colors: ["rgba(var(--primary),1)"],
                  plotOptions: {
                    radialBar: {
                      startAngle: -90,
                      endAngle: 90,
                      track: {
                        background: "#e7e7e7",
                        strokeWidth: "97%",
                        margin: 5,
                        dropShadow: {
                          enabled: true,
                          top: 2,
                          left: 0,
                          color: "#999",
                          opacity: 1,
                          blur: 2,
                        },
                      },
                      dataLabels: {
                        name: { show: false },
                        value: { offsetY: -4, fontSize: "22px" },
                      },
                    },
                  },
                  grid: { padding: { top: -20 } },
                  fill: {
                    type: "",
                    gradient: {
                      shade: "",
                      shadeIntensity: 0.4,
                      inverseColors: false,
                      opacityFrom: 1,
                      opacityTo: 1,
                      stops: [0, 60, 73, 108],
                    },
                  },
                  labels: ["Average Results"],
                }}
              />
            ) : (
              <Loading />
            )}
          </div>
          <Link
            href="/apps/book-library/unlocked"
            className="file-manager-sidebar mb-4 d-flex align-items-center position-relative text-decoration-none text-reset"
          >
            <span
              className="text-light-primary h-40 w-40 d-flex-center b-r-10 position-absolute"
            >
              <Image size={18} weight="duotone" alt="" />
            </span>
            <div className="flex-grow-1 ms-5">
              <h6 className="mb-0">Unlocked Books</h6>
              <p className="text-secondary mb-0">
                {unlockedCount === null
                  ? "Loading…"
                  : `${unlockedCount} Book${unlockedCount !== 1 ? "s" : ""}`}
              </p>
            </div>
            <IconChevronRight size={18} className="text-secondary" />
          </Link>
          {bookCategories.map((category, index) => (
            <div className="file-manager-sidebar mb-4" key={index}>
              <div className="d-flex align-items-center position-relative">
                <span
                  className={`${category.colorClass} h-40 w-40 d-flex-center b-r-10 position-absolute`}
                >
                  {category.icon}
                </span>
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
