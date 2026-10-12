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
