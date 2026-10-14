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
   
    title: "Dashboard",
    iconClass: HomeAlt,
    name: "dashboard",
    path: "/dashboard/ecommerce",
    
  },
  {
   
    iconClass: AppleShortcuts,
    collapseId: "apps",
    name: "My Profile",
    path: "/apps/setting",
   
  },
  {
    name: "Ugrade to Pro",
    path: "/apps/pricing",
    iconClass: ShoppingBagPlus,
  },
  
  
   {
    name: "Book Libary",
    path: "/apps/file-manager",
    iconClass: PageStar,
  },
 
  
  
 
  {
    name: "Support",
    path: "mailto:teqlathemes@gmail.com",
    iconClass: ChatBubbleQuestion,
  },
  {
    type: "link",
    title: "Libary",
    iconClass: KeyframesCouple,
    name: "libary",
   
    path: "/level",
   
  },
  {
    type: "link",
    title: "Settings",
    iconClass: KeyframesCouple,
    name: "Settings",
   
    path: "/level",
   
  },
  {
    type: "link",
    title: "Whatsapp",
    iconClass: KeyframesCouple,
    name: "Whatsapp",
    
    path: "/level",
   
  },
  {
    type: "link",
    title: "Logout",
    iconClass: KeyframesCouple,
    name: "Logout",
   
    path: "/level",
   
  },
];
