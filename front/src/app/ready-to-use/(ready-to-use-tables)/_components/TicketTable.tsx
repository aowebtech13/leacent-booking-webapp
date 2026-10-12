import { Card, CardHeader } from "reactstrap";
import CustomDataTable from "@/Component/DataTable/CustomDataTable";

interface Ticket {
  id: number;
  ticketId: string;
  subject: string;
  status: string;
  statusColor: string;
  priority: string;
  priorityColor: string;
  assignee: string;
  createdAt: string;
  updatedAt: string;
}

const ticketsData: Ticket[] = [
  {
    id: 1,
    ticketId: "TCK-2024-001",
    subject: "Login issue with SSO",
    status: "Open",
    statusColor: "primary",
    priority: "High",
    priorityColor: "danger",
    assignee: "John Doe",
    createdAt: "2024-01-15",
    updatedAt: "2024-01-15",
  },
  {
    id: 2,
    ticketId: "TCK-2024-002",
    subject: "Payment gateway timeout",
    status: "In Progress",
    statusColor: "warning",
    priority: "Critical",
    priorityColor: "danger",
    assignee: "Jane Smith",
    createdAt: "2024-01-16",
    updatedAt: "2024-01-17",
  },
  {
    id: 3,
    ticketId: "TCK-2024-003",
    subject: "UI bug on dashboard",
    status: "Resolved",
    statusColor: "success",
    priority: "Medium",
    priorityColor: "warning",
    assignee: "Mike Johnson",
    createdAt: "2024-01-14",
    updatedAt: "2024-01-18",
  },
  {
    id: 4,
    ticketId: "TCK-2024-004",
    subject: "API rate limiting",
    status: "Closed",
    statusColor: "secondary",
    priority: "Low",
    priorityColor: "info",
    assignee: "Sarah Wilson",
    createdAt: "2024-01-13",
    updatedAt: "2024-01-19",
  },
  {
    id: 5,
    ticketId: "TCK-2024-005",
    subject: "Database connection leak",
    status: "Open",
    statusColor: "primary",
    priority: "High",
    priorityColor: "danger",
    assignee: "Tom Brown",
    createdAt: "2024-01-18",
    updatedAt: "2024-01-18",
  },
];

const TicketTable = () => {
  const columns = [
    {
      key: "ticketId",
      header: "Ticket ID",
    },
    {
      key: "subject",
      header: "Subject",
    },
    {
      key: "status",
      header: "Status",
      render: (_: any, ticket: Ticket) => (
        <span className={`badge text-outline-${ticket.statusColor}`}>
          {ticket.status}
        </span>
      ),
    },
    {
      key: "priority",
      header: "Priority",
      render: (_: any, ticket: Ticket) => (
        <span className={`badge text-outline-${ticket.priorityColor}`}>
          {ticket.priority}
        </span>
      ),
    },
    { key: "assignee", header: "Assignee" },
    { key: "createdAt", header: "Created" },
    { key: "updatedAt", header: "Updated" },
  ];

  return (
    <Card>
      <CardHeader>
        <h5>Support Tickets</h5>
      </CardHeader>

      <CustomDataTable
        columns={columns}
        data={ticketsData}
        rowKey="id"
        title=""
        showTitle={false}
        showDescription={false}
        showActions={false}
      />
    </Card>
  );
};

export default TicketTable;