import * as React from "react"
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarGroup,
  SidebarGroupLabel,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from "@/components/ui/sidebar"
import {
  Bell,
  ChartSpline,
  ClipboardCheck,
  Info,
  LayoutGrid,
  LogOut,
  MessageCircleMore,
  Network,
  SlidersHorizontal,
  UserRound,
} from "lucide-react"
import { Tooltip, TooltipTrigger, TooltipContent } from "./ui/tooltip"
import { Link, useNavigate } from "@tanstack/react-router"
import { Avatar, AvatarFallback } from "@/components/ui/avatar"
import { Button } from "@/components/ui/button"
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"
import { useMutation } from "@tanstack/react-query"
import api from "@/lib/api"

const sidebarConfig = [
  {
    group: "Overview",
    items: [
      {
        path: "/admin/dashboard",
        label: "Dashboard and Analytics",
        icon: LayoutGrid,
      },
    ],
  },
  {
    group: "CRM",
    items: [
      {
        path: "/admin/lead-and-client/leads",
        label: "Lead and Client Tracking",
        icon: Network,
      },
      {
        path: "/admin/opportunities",
        label: "Opportunity Pipeline Visualization",
        icon: ChartSpline,
        tooltip: true,
      },
      {
        path: "/admin/communications",
        label: "Communications History",
        icon: MessageCircleMore,
      },
      {
        path: "/admin/client-satisfactions",
        label: "Client Satisfaction and Surveys",
        icon: ClipboardCheck,
      },
      {
        path: "/admin/reminders",
        label: "Follow-up Reminders",
        icon: Bell,
      },
    ],
  },
  {
    group: "Administration",
    items: [
      {
        path: "/admin/users",
        label: "User Management",
        icon: SlidersHorizontal,
      },
      {
        path: "/admin/audit-log",
        label: "Audit Logs",
        icon: Info,
      },
      {
        path: "/admin/account",
        label: "Account",
        icon: UserRound,
      },
    ],
  },
]

export function AppSidebar({ ...props }: React.ComponentProps<typeof Sidebar>) {
  const navigate = useNavigate()

  return (
    <Sidebar variant="inset" {...props}>
      <SidebarHeader>
        <SidebarMenu>
          <SidebarMenuItem>
            <SidebarMenuButton size="lg" asChild>
              <Link to="/admin/dashboard-and-analytics">
                <img
                  src="/pms-logo.png"
                  alt="pms-logo"
                  className="h-auto w-18"
                />
                <div className="grid flex-1 text-left text-sm leading-tight">
                  <span className="truncate font-medium">Primepower</span>
                  <span className="truncate text-xs">CRM Department</span>
                </div>
              </Link>
            </SidebarMenuButton>
          </SidebarMenuItem>
        </SidebarMenu>
      </SidebarHeader>
      <SidebarContent>
        {sidebarConfig.map((group) => (
          <SidebarGroup key={group.group}>
            <SidebarGroupLabel>{group.group}</SidebarGroupLabel>
            <SidebarMenu>
              {group.items.map((item) =>
                item.tooltip ? (
                  <Tooltip key={item.path}>
                    <TooltipTrigger asChild>
                      <SidebarMenuItem>
                        <SidebarMenuButton
                          onClick={() => navigate({ to: item.path })}
                        >
                          <item.icon />
                          <span>{item.label}</span>
                        </SidebarMenuButton>
                      </SidebarMenuItem>
                    </TooltipTrigger>
                    <TooltipContent side="right">{item.label}</TooltipContent>
                  </Tooltip>
                ) : (
                  <SidebarMenuItem key={item.path}>
                    <SidebarMenuButton
                      onClick={() => navigate({ to: item.path })}
                    >
                      <item.icon />
                      <span>{item.label}</span>
                    </SidebarMenuButton>
                  </SidebarMenuItem>
                )
              )}
            </SidebarMenu>
          </SidebarGroup>
        ))}
      </SidebarContent>
      <SidebarFooter>
        <div className="flex items-center gap-4">
          <AccountDropdown />
          <div className="flex flex-col text-xs">
            <div>Daniel Balisi</div>
            <div className="text-muted-foreground">Administrator</div>
          </div>
          <Button variant="outline" size="icon-lg" className="ml-auto">
            <Bell />
          </Button>
        </div>
      </SidebarFooter>
    </Sidebar>
  )
}

import { Spinner } from "@/components/ui/spinner"

function AccountDropdown() {
  const navigate = useNavigate()

  const mutation = useMutation({
    mutationFn: async () => {
      return api.post("/api/logout")
    },
    onSuccess: () => {
      return navigate({ to: "/login" })
    },
  })
  return (
    <>
      <DropdownMenu>
        <DropdownMenuTrigger asChild>
          <Button variant="ghost" size="icon" className="rounded-full">
            <Avatar>
              <AvatarFallback>DA</AvatarFallback>
            </Avatar>
          </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
          <DropdownMenuGroup>
            <DropdownMenuItem>
              <UserRound />
              Account
            </DropdownMenuItem>
            <DropdownMenuItem>
              <Bell />
              Notifications
            </DropdownMenuItem>
          </DropdownMenuGroup>
          <DropdownMenuSeparator />
          <DropdownMenuItem
            variant="destructive"
            onClick={async () => await mutation.mutateAsync()}
          >
            <LogOut />
            Sign Out
          </DropdownMenuItem>
        </DropdownMenuContent>
      </DropdownMenu>
      {mutation.isPending && (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-white/70">
          <Spinner className="size-10" />
        </div>
      )}
    </>
  )
}
