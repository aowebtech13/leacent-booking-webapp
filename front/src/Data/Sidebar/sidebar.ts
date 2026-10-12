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
    name: "My Profile",
    path: "/apps/setting",
   
  },
  {
    name: "Ugrade to Pro",
    path: "/widgets",
    iconClass: ShoppingBagPlus,
  },
  
  
   {
    name: "Book Libary",
    path: "/apps/file-manager",
    iconClass: PageStar,
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
    name: "Support",
    path: "mailto:teqlathemes@gmail.com",
    iconClass: ChatBubbleQuestion,
  },
];
