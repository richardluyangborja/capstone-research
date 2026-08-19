import { Badge } from "@/components/ui/badge"
import { Button } from "@/components/ui/button"
import { Card, CardContent, CardHeader } from "@/components/ui/card"
import { Input } from "@/components/ui/input"
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"
import { Ellipsis, FunnelPlus, Search } from "lucide-react"
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"
import { useNavigate } from "@tanstack/react-router"
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar"
import useClientsQuery from "./-useClientsQuery"
import { Spinner } from "@/components/ui/spinner"

export type ClientTableRow = {
  id: number
  company: {
    name: string
    industry: string
    logoHref?: string
    logoFallback?: string
  }
  source: string
  primary_contact?: {
    name: string
    title: string
  }
  status: "active" | "inactive"
  sales_representative: {
    name: string
    profileHref?: string
    profileFallback?: string
  }
  recentActivity?: Date
}

export default function ClientTable() {
  const navigate = useNavigate()
  const query = useClientsQuery()
  const data = query.data

  return (
    <Card>
      <CardHeader>
        <div className="flex items-center gap-2">
          <Button variant="outline" size="icon">
            <Search />
          </Button>
          <Input placeholder="Search client..." className="w-xs" />
          <Button variant="outline" size="icon">
            <FunnelPlus />
          </Button>
        </div>
      </CardHeader>
      <CardContent>
        {query.isPending ? (
          <Spinner />
        ) : (
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Company</TableHead>
                <TableHead>Source</TableHead>
                <TableHead>Primary Contact</TableHead>
                <TableHead>Status</TableHead>
                <TableHead>Sales Representative</TableHead>
                <TableHead>Last Activity</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {data?.map((client) => (
                <TableRow
                  key={client.id}
                  onClick={() =>
                    navigate({
                      to: "/admin/client/$clientId",
                      params: { clientId: client.id.toString() },
                    })
                  }
                >
                  <TableCell className="font-medium">
                    <div className="flex items-center gap-2">
                      <Avatar>
                        <AvatarImage src={client.company.logoHref} />
                        <AvatarFallback>
                          {client.company.logoFallback}
                        </AvatarFallback>
                      </Avatar>
                      <div className="flex flex-col">
                        <span>{client.company.name}</span>
                        <span className="text-xs font-normal text-muted-foreground">
                          {client.company.industry}
                        </span>
                      </div>
                    </div>
                  </TableCell>
                  <TableCell>{client.source}</TableCell>
                  <TableCell className="flex flex-col">
                    <span>{client.primary_contact?.name}</span>
                    <span className="text-xs text-muted-foreground">
                      {client.primary_contact?.title}
                    </span>
                  </TableCell>
                  <TableCell>
                    <Badge variant="secondary">{client.status}</Badge>
                  </TableCell>
                  <TableCell>
                    <div className="flex items-center gap-2">
                      <Avatar>
                        <AvatarImage
                          src={client.sales_representative.profileHref}
                        />
                        <AvatarFallback>
                          {client.sales_representative.profileFallback}
                        </AvatarFallback>
                      </Avatar>
                      <span>{client.sales_representative.name}</span>
                    </div>
                  </TableCell>
                  <TableCell>{client.recentActivity?.toDateString()}</TableCell>
                  <TableCell>
                    <DropdownMenu>
                      <DropdownMenuTrigger asChild>
                        <Button variant="ghost" size="icon">
                          <Ellipsis />
                        </Button>
                      </DropdownMenuTrigger>
                      <DropdownMenuContent>
                        <DropdownMenuGroup>
                          <DropdownMenuLabel>Actions</DropdownMenuLabel>
                          <DropdownMenuItem>View</DropdownMenuItem>
                          <DropdownMenuItem>Edit</DropdownMenuItem>
                        </DropdownMenuGroup>
                        <DropdownMenuSeparator />
                        <DropdownMenuGroup>
                          <DropdownMenuItem variant="destructive">
                            Delete
                          </DropdownMenuItem>
                        </DropdownMenuGroup>
                      </DropdownMenuContent>
                    </DropdownMenu>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        )}
      </CardContent>
    </Card>
  )
}
