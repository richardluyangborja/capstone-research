import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar"
import { Badge } from "@/components/ui/badge"
import { Button } from "@/components/ui/button"
import {
  Card,
  CardAction,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"
import { Separator } from "@/components/ui/separator"
import { createFileRoute, useRouter } from "@tanstack/react-router"
import {
  ChevronLeft,
  Mail,
  MoveUpRight,
  Pencil,
  Phone,
  Plus,
  Trash,
} from "lucide-react"

export type ClientInfoPage = {
  company: {
    logoHref?: string
    logoFallback: string
    name: string
    industry: string
    address: string
    phone: string
    email: string
    website: string
  }
  leadInfo: {
    status: "active" | "inactive"
    source: string
    salesRepresentative: {
      name: string
      profileHref?: string
      profileFallback: string
    }
    createdAt: Date
    recentActivity: Date
  }
  contacts: {
    profileHref?: string
    profileFallback: string
    name: string
    title: string
    email: string
    phone: string
  }[]
}

function getLead(): ClientInfoPage {
  return {
    company: {
      logoFallback: "AB",
      name: "ABC Manufacturing",
      industry: "Manufacturing",
      address: "Quezon City, Metro Manila",
      phone: "(+63) 021 812 4567",
      email: "abcmanufacturing@email.com",
      website: "https://abcmanufacturing.com",
    },
    leadInfo: {
      status: "active",
      source: "Referral",
      salesRepresentative: {
        name: "Andrei Simon",
        profileFallback: "AN",
      },
      createdAt: new Date(),
      recentActivity: new Date(),
    },
    contacts: [
      {
        profileFallback: "JU",
        name: "Juan Dela Cruz",
        title: "Chief Executive Officer",
        email: "juan@abcmanufacturing.com",
        phone: "(+63) 021 812 4567",
      },
      {
        profileFallback: "MA",
        name: "Maria Santos",
        title: "Operations Director",
        email: "maria@abcmanufacturing.com",
        phone: "(+63) 021 812 4568",
      },
    ],
  }
}

export const Route = createFileRoute("/admin/client/$clientId/")({
  component: RouteComponent,
  loader: getLead,
})

function RouteComponent() {
  const router = useRouter()
  const client = Route.useLoaderData()

  return (
    <div className="px-4 pb-8">
      <header className="py-4">
        <Button variant="link" onClick={() => router.history.back()}>
          <ChevronLeft />
          <span>Back</span>
        </Button>
      </header>
      <main>
        <header>
          <div className="flex items-center gap-3">
            <Avatar size="lg">
              <AvatarImage src={client.company.logoHref} />
              <AvatarFallback>{client.company.logoFallback}</AvatarFallback>
            </Avatar>
            <div className="flex flex-col gap-1">
              <h1 className="font-heading text-lg">{client.company.name}</h1>
              <div className="flex items-center gap-1">
                <Badge variant="secondary">{client.leadInfo.status}</Badge>
                <Badge variant="secondary" asChild>
                  <a href={client.company.website}>
                    <span>{client.company.website}</span>
                    <MoveUpRight />
                  </a>
                </Badge>
              </div>
            </div>
          </div>
        </header>
        <div className="mt-6 flex flex-col gap-6">
          <CompanyInfoCard />
          <LeadInfoCard />
          <Separator />
          <ContactInfoSection />
        </div>
      </main>
    </div>
  )
}

function CompanyInfoCard() {
  const client = Route.useLoaderData()

  return (
    <section>
      <Card>
        <CardHeader>
          <CardTitle>Company Information</CardTitle>
          <CardAction>
            <Button variant="outline" size="icon">
              <Pencil />
            </Button>
          </CardAction>
        </CardHeader>
        <CardContent className="grid grid-cols-2 gap-4">
          <div>
            <span className="block text-sm text-muted-foreground">
              Industry
            </span>
            <span>{client.company.industry}</span>
          </div>
          <div>
            <span className="block text-sm text-muted-foreground">Address</span>
            <span>{client.company.address}</span>
          </div>
          <div>
            <span className="block text-sm text-muted-foreground">Phone</span>
            <span>{client.company.phone}</span>
          </div>
          <div>
            <span className="block text-sm text-muted-foreground">Email</span>
            <span>{client.company.email}</span>
          </div>
        </CardContent>
      </Card>
    </section>
  )
}

function LeadInfoCard() {
  const client = Route.useLoaderData()

  return (
    <section>
      <Card>
        <CardHeader>
          <CardTitle>Client Information</CardTitle>
          <CardDescription>
            Created at {client.leadInfo.createdAt.toDateString()}
          </CardDescription>
          <CardAction>
            <Button variant="outline" size="icon">
              <Pencil />
            </Button>
          </CardAction>
        </CardHeader>
        <CardContent className="grid grid-cols-2 gap-4">
          <div>
            <span className="block text-sm text-muted-foreground">Status</span>
            <Badge variant="secondary">{client.leadInfo.status}</Badge>
          </div>
          <div>
            <span className="block text-sm text-muted-foreground">Source</span>
            <span>{client.leadInfo.source}</span>
          </div>
          <div className="flex items-center gap-1">
            <Avatar>
              <AvatarImage
                src={client.leadInfo.salesRepresentative.profileHref}
              />
              <AvatarFallback>
                {client.leadInfo.salesRepresentative.profileFallback}
              </AvatarFallback>
            </Avatar>
            <div>
              <span className="block text-sm text-muted-foreground">
                Sales Representative
              </span>
              <span>{client.leadInfo.salesRepresentative.name}</span>
            </div>
          </div>
          <div>
            <span className="block text-sm text-muted-foreground">
              Recent Activity
            </span>
            <span>{client.leadInfo.recentActivity.toDateString()}</span>
          </div>
        </CardContent>
      </Card>
    </section>
  )
}

function ContactInfoSection() {
  const lead = Route.useLoaderData()

  return (
    <section>
      <header>
        <h2 className="font-heading text-lg">Contacts</h2>
        <Button variant="outline" className="my-2 w-full">
          <Plus />
          <span>Add a contact</span>
        </Button>
      </header>
      <div className="grid grid-cols-2 gap-4">
        {lead.contacts.map((contact, i) => (
          <Card key={i}>
            <CardHeader>
              <CardTitle>{contact.name}</CardTitle>
              <CardDescription>{contact.title}</CardDescription>
              <CardAction>
                <Button variant="outline" size="icon">
                  <Pencil />
                </Button>
              </CardAction>
            </CardHeader>
            <CardContent className="flex items-center gap-4">
              <div className="flex items-center gap-1">
                <Mail size={18} className="text-muted-foreground" />
                <span>{contact.email}</span>
              </div>
              <div className="flex items-center gap-1">
                <Phone size={18} className="text-muted-foreground" />
                <span>{contact.phone}</span>
              </div>
            </CardContent>

            <Separator />
            <CardFooter>
              <Button variant="destructive" size="sm">
                <Trash />
                <span>Delete this contact</span>
              </Button>
            </CardFooter>
          </Card>
        ))}
      </div>
    </section>
  )
}
