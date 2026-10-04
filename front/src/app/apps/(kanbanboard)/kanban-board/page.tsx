import React from "react";
import KanbanBoardPage from "@/app/apps/(kanbanboard)/_components/KanbanBoardPage";
import type { Metadata } from "next";

export const dynamic = "force-static";

export async function generateMetadata(): Promise<Metadata> {
  return {
    title: "Kanban Board - Axelit",
    description:
      "Visualize and manage your tasks with our interactive Kanban board system.",
    keywords: [
      "Kanban board",
      "task management",
      "project management",
      "workflow visualization",
      "task tracking",
      "Kanban system",
      "task organization",
      "Kanban cards",
      "board customization",
      "task status",
      "Kanban columns",
      "task assignment",
      "Kanban workflow",
      "task prioritization",
      "Kanban metrics",
    ],
    openGraph: {
      title: "Kanban Board - Axelit",
      description:
        "Visualize and manage your tasks with our interactive Kanban board system.",
      url: "https://axelit-next.vercel.app/apps/kanban-board",
      siteName: "Axelit-next",
      locale: "en_US",
      type: "website",
    },
  };
}

const Page = () => {
  return (
    <div>
      <KanbanBoardPage />
    </div>
  );
};

export default Page;
