import {
  AppleShortcuts,
  Archive,
  Book,
  ChatBubbleQuestion,
  HomeAlt,
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
    iconClass: Settings,
    name: "My Profile",
    path: "/apps/setting",
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
    title: "More",
    iconClass: AppleShortcuts,
    type: "dropdown",
    collapseId: "more-menu",
    name: "More",
    children: [
      {
        name: "Library",
        path: "/level",
      },
      {
        name: "Settings",
        path: "/level",
      },
      {
        name: "WhatsApp",
        path: "/level",
      },
    ],
  },
];
