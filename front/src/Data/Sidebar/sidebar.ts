import {
  AppleShortcuts,
  Archive,
  Book,
  ChatBubbleQuestion,
  HomeAlt,
  LogOut,
  Settings,
  User,
} from "iconoir-react";
import { MenuItemProps } from "@/interface/common";

export const MenuList: MenuItemProps[] = [
  {
    title: "Dashboard",
    iconClass: HomeAlt,
    name: "Dashboard",
    path: "/dashboard",
  },
  {
    name: "Upgrade to Pro",
    path: "/apps/pricing",
    iconClass: Archive,
  },
  {
    name: "Book Library",
    path: "/apps/book-library",
    iconClass: Book,
  },
  {
    name: "Authors",
    path: "/apps/authors",
    iconClass: User,
  },
  {
    name: "Support",
    path: "mailto:teqlathemes@gmail.com",
    iconClass: ChatBubbleQuestion,
  },
  {
    iconClass: Settings,
    name: "My Profile",
    path: "/apps/setting",
  },
  {
    title: "More",
    iconClass: AppleShortcuts,
    type: "dropdown",
    collapseId: "more-menu",
    name: "More",
    children: [
      {
        name: "Facebook",
        path: "https://www.facebook.com/leacentng",
      },
     
      {
        name: "WhatsApp",
        path: "https://chat.whatsapp.com/CRMLEqwPgR7AFi90exHHgv?s=cl&p=a&mlu=0",
      },
    ],
  },
  {
    iconClass: LogOut,
    name: "Logout",
    path: "/logout",
  },
];
