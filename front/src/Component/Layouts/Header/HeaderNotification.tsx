import React, { useState, useEffect } from "react";
import Link from "next/link";
import { Bell, Xmark } from "iconoir-react";
import { Offcanvas, OffcanvasHeader, OffcanvasBody } from "reactstrap";
import {
  fetchNotifications,
  fetchUnreadCount,
  markAsRead,
  deleteNotification,
  type Notification,
} from "@/lib/api";
import Image from "next/image";

const HeaderNotification: React.FC = () => {
  const [notifications, setNotifications] = useState<Notification[]>([]);
  const [isOpen, setIsOpen] = useState(false);
  const [unreadCount, setUnreadCount] = useState(0);
  const [isLoading, setIsLoading] = useState(true);

  const loadNotifications = async () => {
    try {
      const [notifs, count] = await Promise.all([
        fetchNotifications(),
        fetchUnreadCount(),
      ]);
      setNotifications(notifs);
      setUnreadCount(count);
    } catch {
      // Ignore errors for now
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    loadNotifications();
  }, []);

  const handleRemoveNotification = async (id: number) => {
    try {
      await deleteNotification(id);
      const updated = notifications.filter((n) => n.id !== id);
      setNotifications(updated);
      if (unreadCount > 0) setUnreadCount(unreadCount - 1);
    } catch {
      // Ignore errors
    }
  };

  const formatNotification = (notification: Notification) => {
    const data = notification.data;
    return {
      id: notification.id,
      name: data.title || "Notification",
      action: data.message || "",
      file: data.file,
      avatar: data.avatar,
      iconClass: data.iconClass,
      bgClass: data.bgClass || "bg-secondary",
      date: data.date || new Date(notification.created_at).toLocaleDateString(),
      dateBadgeClass: data.dateBadgeClass || "text-light-secondary",
      read_at: notification.read_at,
    };
  };

  const formattedNotifications = (notifications ?? []).map(formatNotification);

  return (
    <div>
      <a
        className="d-block head-icon position-relative bg-transparent border-0 shadow-none p-0"
        onClick={() => {
          setIsOpen(true);
          loadNotifications();
        }}
      >
        <Bell className="fs-6" />
        {unreadCount > 0 && (
          <span className="position-absolute translate-middle p-1 bg-success border border-light rounded-circle animate__animated animate__fadeIn animate__infinite animate__slower"></span>
        )}
      </a>

      <Offcanvas
        direction="end"
        isOpen={isOpen}
        toggle={() => setIsOpen(false)}
        className="header-notification-canvas"
      >
        <OffcanvasHeader toggle={() => setIsOpen(false)}>
          Notification
        </OffcanvasHeader>
        <OffcanvasBody className="notification-offcanvas-body app-scroll p-0">
          <div className="head-container notification-head-container">
            {isLoading ? (
              <div className="hidden-massage py-4 px-3 text-center">
                <div className="spinner-border text-primary" role="status">
                  <span className="visually-hidden">Loading...</span>
                </div>
              </div>
            ) : formattedNotifications.length > 0 ? (
              formattedNotifications.map((notification) => (
                <div
                  className={`notification-message head-box d-flex gap-2 align-items-start ${
                    notification.read_at ? "" : "unread"
                  }`}
                  key={notification.id}
                >
                  <div className="message-images">
                    {notification.avatar ? (
                      <span
                        className={`${notification.bgClass} h-35 w-35 d-flex-center b-r-10 position-relative`}
                      >
                        <Image
                          alt="avatar"
                          className="img-fluid b-r-10"
                          src={notification.avatar}
                          width={35}
                          height={35}
                        />
                        <span className="position-absolute bottom-30 end-0 p-1 bg-secondary border border-light rounded-circle notification-avatar"></span>
                      </span>
                    ) : (
                      <span
                        className={`${notification.bgClass} h-35 w-35 d-flex-center b-r-10 position-relative`}
                      >
                        <i className={`${notification.iconClass} f-s-18`}></i>
                      </span>
                    )}
                  </div>
                  <div className="message-content-box flex-grow-1 ps-2">
                    <Link
                      className="f-s-15 text-secondary mb-0"
                      href="/apps/email-page/read_email"
                      target="_blank"
                      rel="noopener noreferrer"
                    >
                      <span className="f-w-500 text-secondary">
                        {notification.name}
                      </span>{" "}
                      {notification.action}{" "}
                      {notification.file && (
                        <span className="f-w-500 text-secondary">
                          {notification.file}
                        </span>
                      )}
                    </Link>
                    {notification.action ===
                      "invited you to join a meeting" && (
                      <div>
                        <a
                          className="d-inline-block f-w-500 text-success me-1"
                          href="#"
                        >
                          Join
                        </a>
                        <a
                          className="d-inline-block f-w-500 text-danger"
                          href="#"
                        >
                          Decline
                        </a>
                      </div>
                    )}
                    <span
                      className={`badge ${notification.dateBadgeClass} mt-2`}
                    >
                      {notification.date}
                    </span>
                  </div>
                  <div className="align-self-start text-end">
                    <Xmark
                      className="close-btn cursor-pointer"
                      onClick={() => handleRemoveNotification(notification.id)}
                    />
                  </div>
                </div>
              ))
            ) : (
              <div className="hidden-massage py-4 px-3 text-center">
                <Image
                  alt=""
                  className="w-50 h-50 mb-3 mt-2"
                  src="/images/icons/bell.png"
                  width={80}
                  height={80}
                />
                <div>
                  <h6 className="mb-0">Notification Not Found</h6>
                  <p className="text-secondary">
                    When you have any notifications, they will appear here.
                  </p>
                </div>
              </div>
            )}
          </div>
        </OffcanvasBody>
      </Offcanvas>
    </div>
  );
};

export default HeaderNotification;
