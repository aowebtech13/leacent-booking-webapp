import {
  AppleShortcuts,
  Archive,
  Book,
  ChatBubbleQuestion,
  Coins,
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
    name: "Transaction History",
    path: "/apps/transactions",
    iconClass: Archive,
  },

  {
    iconClass: Coins,
    name: "Purchase Points",
    path: "/apps/pricing",
  },

  {
    iconClass: Settings,
    name: "My Profile",
    path: "/apps/setting",
  },
  {
    name: "Support",
    path: "mailto:firstbornpublishing923@gmail.com",
    iconClass: ChatBubbleQuestion,
  },
  {
    title: "Socials",
    iconClass: AppleShortcuts,
    type: "dropdown",
    collapseId: "more-menu",
    name: "Media",
    children: [
      {
        name: "Facebook",
        path: "https://www.facebook.com/leacentng",
      },

      {
        name: "WhatsApp",
        path: "https://chat.whatsapp.com/CRMLEqwPgR7AFi90exHHgv?s=cl&p=a&mlu=0",
      },
      {
        name: "Youtube",
        path: "https://www.youtube.com/@BusinessLabSeries",
      },
      {
        name: "Tiktok",
        path: "https://www.tiktok.com/@officialbusinesslab?_r=1&_t=ZS-9AUYlbwxj64",
      },
    ],
  },
  {
    iconClass: LogOut,
    name: "Logout",
    path: "/logout",
  },
];
