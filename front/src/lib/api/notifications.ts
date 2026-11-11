import api from "./client";

export interface Notification {
  id: string;
  type: string;
  data: {
    title?: string;
    message?: string;
    avatar?: string;
    action?: string;
    file?: string;
    iconClass?: string;
    bgClass?: string;
    date?: string;
    dateBadgeClass?: string;
    action_url?: string;
    [key: string]: any;
  };
  read_at: string | null;
  created_at: string;
  updated_at: string;
}

export interface NotificationsResponse {
  data: Notification[];
}

export interface UnreadCountResponse {
  count: number;
}

export async function fetchNotifications(): Promise<Notification[]> {
  const res = await api.get("notifications");
  const data = res.data as Notification[];
  return Array.isArray(data) ? data : [];
}

export async function fetchUnreadCount(): Promise<number> {
  const res = await api.get("notifications/unread-count");
  return (res.data as UnreadCountResponse).count;
}

export async function markAsRead(id: string): Promise<void> {
  await api.post(`notifications/${id}/read`);
}

export async function markAllAsRead(): Promise<void> {
  await api.post("notifications/read-all");
}

export async function deleteNotification(id: string): Promise<void> {
  await api.delete(`notifications/${id}`);
}
