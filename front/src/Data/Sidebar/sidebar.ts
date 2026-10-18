import {
  AppleShortcuts,
  Archive,
  Book,
  BookmarkBook,
  ChatBubbleQuestion,
  Dashboard,
  Folder,
  HomeAlt,
  LogOut,
  Settings,
  User,
} from "iconoir-react";

export const MenuList = [
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
    path: "/apps/file-manager",
    iconClass: Book,
  },
  {
    name: "Books",
    path: "/admin/books",
    iconClass: Book,
  },
  {
    name: "Authors",
    path: "/admin/authors",
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
        iconClass: BookmarkBook,
      },
      {
        name: "Settings",
        path: "/level",
        iconClass: Settings,
      },
      {
        name: "WhatsApp",
        path: "/level",
        iconClass: ChatBubbleQuestion,
      },
    ],
  },
];