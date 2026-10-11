import {
  AppleShortcuts,
  Archive,
  Book,
  BookmarkBook,
  ChatBubbleQuestion,
  Component,
  Handbag,
  HomeAlt,
  KeyframesCouple,
  LayoutRight,
  Lifebelt,
  MapPin,
  MultiplePages,
  PageStar,
  ReportColumns,
  ShoppingBagPlus,
  ViewGrid,
  WarningTriangle,
} from "iconoir-react";

export const MenuList = [
  {
    type: "dropdown",
    title: "Dashboard",
    iconClass: HomeAlt,
    name: "dashboard",
    path: "/dashboard/ecommerce",
    
  },
  {
    type: "dropdown",
    iconClass: AppleShortcuts,
    collapseId: "apps",
    name: "apps",
    path: "/apps",
    children: [
      { name: "Calendar", path: "/apps/calendar" },
      {
        name: "Profile Page",
        path: "/Apexcharts",
        collapseId: "profile-page",
        children: [
          { name: "Profile", path: "/apps/profile" },
          { name: "Setting", path: "/apps/setting" },
        ],
      },
      {
        name: "Projects Page",
        path: "/Apexcharts",
        collapseId: "projects-page",
        children: [
          { name: "Projects", path: "/apps/projects-page/projects" },
          {
            name: "Projects Details",
            path: "/apps/projects-page/projects-details",
          },
        ],
      },
      { name: "To-Do", path: "/apps/todo" },
      { name: "Team", path: "/apps/team" },
      { name: "Api", path: "/apps/api" },
      {
        name: "Ticket",
        path: "/Apexcharts.html",
        collapseId: "ticket-page",
        children: [
          { name: "Ticket", path: "/apps/ticket-page/ticket" },
          { name: "Ticket Details", path: "/apps/ticket-page/ticket-details" },
        ],
      },
      {
        name: "Emails Page",
        path: "/Apexcharts.html",
        collapseId: "email-page",
        children: [
          { name: "Email", path: "/apps/email-page/email" },
          { name: "Read Email", path: "/apps/email-page/read-email" },
        ],
      },
      {
        name: "E-shop",
        path: "/Apexcharts.html",
        collapseId: "e-shop",
        children: [
          { name: "Cart", path: "/apps/e-shop/cart" },
          { name: "Product", path: "/apps/e-shop/product" },
          { name: "Add Product", path: "/apps/e-shop/add-product" },
          {
            name: "Product-Details",
            path: "/apps/e-shop/product-details",
          },
          { name: "Product list", path: "/apps/e-shop/product-list" },
          { name: "Orders", path: "/apps/e-shop/orders" },
          { name: "Orders Details", path: "/apps/e-shop/orders-details" },
          { name: "Orders List", path: "/apps/e-shop/orders-list" },
          { name: "Checkout", path: "/apps/e-shop/checkout" },
          { name: "Wishlist", path: "/apps/e-shop/wishlist" },
        ],
      },
      { name: "Invoice", path: "/apps/invoice" },
      { name: "Chat", path: "/apps/chat" },
      { name: "File Manager", path: "/apps/file-manager" },
      { name: "Bookmark", path: "/apps/bookmark" },
      { name: "kanban board", path: "/apps/kanban-board" },
      { name: "Timeline", path: "/apps/timeline" },
      { name: "FAQ", path: "/apps/faq" },
      { name: "Pricing", path: "/apps/pricing" },
      { name: "Gallery", path: "/apps/gallery" },
      {
        name: "Blog Page",
        path: "/Apexcharts.html",
        collapseId: "blog-page",
        children: [
          { name: "Blog", path: "/apps/blog-page/blog" },
          { name: "Blog Details", path: "/apps/blog-page/blog-details" },
          { name: "Add Blog", path: "/apps/blog-page/add-blog" },
        ],
      },
    ],
  },
  {
    name: "Widgets",
    path: "/widgets",
    iconClass: ViewGrid,
  },
  
  
  
 
  
  {
    type: "dropdown",
    title: "Others",
    iconClass: KeyframesCouple,
    name: "2 level",
    collapseId: "level",
    path: "/level",
    children: [
      { name: "Blank", path: "" },
      {
        name: "Another level",
        path: "/",
        collapseId: "level2",
        children: [{ name: "Blank", path: "/other-pages/blank" }],
      },
    ],
  },
  {
    name: "Document",
    path: "https://phpstack-1384472-5121645.cloudwaysapps.com/document/next-ts/axelit/index.html",
    iconClass: PageStar,
  },
  {
    name: "Support",
    path: "mailto:teqlathemes@gmail.com",
    iconClass: ChatBubbleQuestion,
  },
];
