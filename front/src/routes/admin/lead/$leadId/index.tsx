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
  Info,
  Mail,
  MoveUpRight,
  Pencil,
  Phone,
  Plus,
  Trash,
} from "lucide-react"
import useLeadDetailsQuery from "./-useLeadDetailsQuery"
import { Spinner } from "@/components/ui/spinner"
import {
  Alert,
  AlertAction,
  AlertDescription,
  AlertTitle,
} from "@/components/ui/alert"

export type LeadInfoPage = {
  id: number
  status: "new" | "qualified" | "converted" | "disqualified"
  source: string
  notes?: string
  sales_representative: {
    name: string
    profileHref?: string
    profileFallback?: string
  }
  created_at: string
  recent_activity?: Date
  company: {
    logoHref?: string
    logoFallback?: string
    name: string
    industry: string
    address: string
    phone: string
    email: string
    website: string
  }
  contacts: {
    profileHref?: string
    profileFallback?: string
    name: string
    title: string
    email: string
    phone: string
  }[]
}

export const Route = createFileRoute("/admin/lead/$leadId/")({
  component: RouteComponent,
})

function RouteComponent() {
  const router = useRouter()
  const { leadId } = Route.useParams()
  const query = useLeadDetailsQuery(leadId)
  const lead = query.data!

  return (
    <div className="px-4 pb-8">
      <header className="py-4">
        <Button variant="link" onClick={() => router.history.back()}>
          <ChevronLeft />
          <span>Back</span>
        </Button>
      </header>
      <main>
        {query.isPending ? (
          <div className="flex justify-center">
            <Spinner />
          </div>
        ) : (
          <>
            <header>
              <div className="flex items-center gap-3">
                <Avatar size="lg">
                  <AvatarImage src={lead.company.logoHref} />
                  <AvatarFallback>{lead.company.logoFallback}</AvatarFallback>
                </Avatar>
                <div className="flex flex-col gap-1">
                  <h1 className="font-heading text-lg">{lead.company.name}</h1>
                  <div className="flex items-center gap-1">
                    <Badge variant="secondary">{lead.status}</Badge>
                    {lead.company.website && (
                      <Badge variant="secondary" asChild>
                        <a href={lead.company.website}>
                          <span>{lead.company.website}</span>
                          <MoveUpRight />
                        </a>
                      </Badge>
                    )}
                  </div>
                </div>
              </div>
            </header>
            <div className="mt-6 flex flex-col gap-6">
              <CompanyInfoCard lead={lead} />
              <LeadInfoCard lead={lead} />
              <Separator />
              <ContactInfoSection lead={lead} />
            </div>{" "}
          </>
        )}
      </main>
    </div>
  )
}

function CompanyInfoCard({ lead }: { lead: LeadInfoPage }) {
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
        <CardContent>
          <div className="mb-4 grid grid-cols-2 gap-4">
            <div>
              <span className="block text-sm text-muted-foreground">
                Industry
              </span>
              <span>{lead.company.industry}</span>
            </div>
            <div>
              <span className="block text-sm text-muted-foreground">
                Address
              </span>
              <span>{lead.company.address}</span>
            </div>
            <div>
              <span className="block text-sm text-muted-foreground">Phone</span>
              <span>{lead.company.phone}</span>
            </div>
            <div>
              <span className="block text-sm text-muted-foreground">Email</span>
              <span>{lead.company.email}</span>
            </div>
          </div>
          {lead.notes && (
            <Alert>
              <Info />
              <AlertTitle>Note</AlertTitle>
              <AlertDescription>{lead.notes}</AlertDescription>
              <AlertAction>
                <Button variant="outline" size="icon">
                  <Pencil />
                </Button>
              </AlertAction>
            </Alert>
          )}
        </CardContent>
      </Card>
    </section>
  )
}

function LeadInfoCard({ lead }: { lead: LeadInfoPage }) {
  return (
    <section>
      <Card>
        <CardHeader>
          <CardTitle>Lead Information</CardTitle>
          <CardDescription>
            Created at {new Date(lead.created_at).toDateString()}
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
            <Badge variant="secondary">{lead.status}</Badge>
          </div>
          <div>
            <span className="block text-sm text-muted-foreground">Source</span>
            <span>{lead.source}</span>
          </div>
          <div className="flex items-center gap-1">
            <Avatar>
              <AvatarImage src={lead.sales_representative.profileHref} />
              <AvatarFallback>
                {lead.sales_representative.profileFallback}
              </AvatarFallback>
            </Avatar>
            <div>
              <span className="block text-sm text-muted-foreground">
                Sales Representative
              </span>
              <span>{lead.sales_representative.name}</span>
            </div>
          </div>
          <div>
            <span className="block text-sm text-muted-foreground">
              Recent Activity
            </span>
             <span>{lead.recent_activity?.toDateString()}</span>
          </div>
        </CardContent>
      </Card>
    </section>
  )
}

function ContactInfoSection({ lead }: { lead: LeadInfoPage }) {
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
