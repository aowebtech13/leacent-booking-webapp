import Scrollbar from "simplebar-react";
import MenuItem from "./MenuItem";
import Link from "next/link";
import { MenuList } from "@/Data/Sidebar/sidebar";
import React, { Fragment, useState, useRef, useEffect } from "react";
import { SidebarProps } from "@/interface/common";
import { IconChevronsRight } from "@tabler/icons-react";
import HorizontalNav from "@/Component/Layouts/Sidebar/HorizontalNav";
import { LogOut } from "iconoir-react";
import { useAuth } from "@/lib/contexts/AuthContext";

const Sidebar: React.FC<SidebarProps> = ({ sidebarOpen, setSidebarOpen }) => {
  const [navTranslateX, setNavTranslateX] = useState(0);
  const [isHorizontal, setIsHorizontal] = useState(false);
  const navRef = useRef<HTMLUListElement>(null);
  const { logout, isAuthenticated } = useAuth();

  const handleLogout = async () => {
    await logout();
  };

  useEffect(() => {
    const getSidebarOption = () => {
      if (typeof window === "undefined") return "vertical-sidebar";
      return localStorage.getItem("Axelit-Next-Theme-sidebar-option");
    };

    const checkSidebarOption = () => {
      const option = getSidebarOption();
      setIsHorizontal(option === "horizontal-sidebar");
    };

    checkSidebarOption();

    const interval = setInterval(checkSidebarOption, 100);
    return () => clearInterval(interval);
  }, []);

  return (
    <nav
      className={["vertical-sidebar", sidebarOpen && "semi-nav"]
        .filter(Boolean)
        .join(" ")}
    >
      <div className="app-logo">
        <Link className="logo d-inline-block" href="/dashboard">
          <img
            src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png"
            alt="#"
            className="dark-logo"
          />
        </Link>
        <span
          className="bg-light-light toggle-semi-nav"
          onClick={() => setSidebarOpen?.(!sidebarOpen)}
        >
          <IconChevronsRight className="f-s-20" />
        </span>
      </div>
      <Scrollbar className="app-nav simplebar-scrollable-y">
        <div
          className="nav-container"
          style={{
            overflow: isHorizontal ? "hidden" : "visible",
          }}
        >
          <ul
            ref={navRef}
            className="main-nav p-0 mt-2"
            style={{
              marginLeft: isHorizontal ? `${navTranslateX}px` : "0px",
              transition: isHorizontal ? "margin-left 0.3s ease" : "none",
            }}
          >
            {MenuList.map((opt, index) => (
              <Fragment key={index}>
                <MenuItem
                  title={opt.title ?? ""}
                  type={opt.type ?? ""}
                  path={opt.path}
                  name={opt.name}
                  iconClass={opt.iconClass}
                  badgeCount={opt.badgeCount}
                  links={opt.children}
                  collapseId={opt.collapseId}
                />
              </Fragment>
            ))}
            <li style={{ marginBottom: "1rem" }} />
          </ul>
        </div>
      </Scrollbar>
      {isAuthenticated && (
        <div className="sidebar-footer p-3 border-top">
          <button
            onClick={handleLogout}
            className="btn btn-light-danger w-100 d-flex align-items-center justify-content-center gap-2"
            type="button"
          >
            <LogOut width={20} height={20} />
            <span>Logout</span>
          </button>
        </div>
      )}
      <HorizontalNav navRef={navRef} onScroll={setNavTranslateX} />
    </nav>
  );
};

export default Sidebar;
