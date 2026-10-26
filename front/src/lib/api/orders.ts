import api from "./client";

export interface OrderItem {
  id: number;
  order_id: number;
  product_id: number | null;
  product_name: string;
  product_sku?: string | null;
  price: number | string;
  quantity: number;
  subtotal: number | string;
  product?: any;
}

export interface Order {
  id: number;
  user_id: number;
  customer_id?: number | null;
  status: string;
  subtotal: number | string;
  tax: number | string;
  shipping_cost: number | string;
  total: number | string;
  currency: string;
  shipping_address?: string | null;
  billing_name?: string | null;
  billing_email?: string | null;
  billing_phone?: string | null;
  payment_method?: string | null;
  payment_status?: string | null;
  notes?: string | null;
  created_at?: string;
  updated_at?: string;
  items?: OrderItem[];
  customer?: any;
}

export interface OrdersResponse {
  current_page: number;
  data: Order[];
  first_page_url?: string;
  from?: number;
  last_page: number;
  last_page_url?: string;
  links?: any[];
  next_page_url?: string | null;
  path?: string;
  per_page: number;
  prev_page_url?: string | null;
  to?: number;
  total: number;
}

export async function getOrders(params?: { per_page?: number; page?: number }) {
  const res = await api.get("orders", { params });
  // api client unwraps envelope to data
  return (res.data as OrdersResponse) ?? (res as any);
}

export async function getOrder(id: number) {
  const res = await api.get(`orders/${id}`);
  return res.data as Order;
}
