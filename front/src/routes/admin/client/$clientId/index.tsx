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
import useClientDetailsQuery from "./-useClientDetailsQuery"
import { Spinner } from "@/components/ui/spinner"
import OpportunitiesSummary, {
  type OpportunitySummary,
} from "@/components/opportunities-summary"
import {
  Alert,
  AlertAction,
  AlertDescription,
  AlertTitle,
} from "@/components/ui/alert"
import {
  CommunicationHistorySection,
  type CommunicationEntry,
} from "@/components/communication-history"
import {
  ReminderHistorySection,
  type ReminderEntry,
} from "@/components/reminders-history"
import { Link } from "@tanstack/react-router"

export type ClientInfoPage = {
  id: number
  status: "active" | "inactive"
  client_since: string
  notes?: string
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
  opportunities?: OpportunitySummary[]
  lead?: {
    id: number
    status: "new" | "qualified" | "disqualified" | "converted"
  }
  communications?: CommunicationEntry[]
  reminders?: ReminderEntry[]
  sales_representative: {
    name: string
    profileHref?: string
    profileFallback?: string
  }
  latest_survey?: {
    id: number
    status: "pending" | "completed" | "expired"
    average_score: string | null
    completed_at: string | null
  } | null
}

export const Route = createFileRoute("/admin/client/$clientId/")({
  component: RouteComponent,
})

function RouteComponent() {
  const router = useRouter()
  const { clientId } = Route.useParams()
  const query = useClientDetailsQuery(clientId)
  const client = query.data!

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
                  <AvatarImage src={client.company.logoHref} />
                  <AvatarFallback>{client.company.logoFallback}</AvatarFallback>
                </Avatar>
                <div className="flex flex-col gap-1">
                  <h1 className="font-heading text-lg">
                    {client.company.name}
                  </h1>
                  <div className="flex items-center gap-1">
                    <Badge variant="secondary">{client.status}</Badge>
                    {client.company.website && (
                      <Badge variant="secondary" asChild>
                        <a href={client.company.website}>
                          <span>{client.company.website}</span>
                          <MoveUpRight />
                        </a>
                      </Badge>
                    )}
                  </div>
                </div>
              </div>
            </header>
            <div className="mt-6 flex flex-col gap-6">
              <CompanyInfoCard client={client} />
              <ClientInfoCard client={client} />
              <Separator />
              <ContactInfoSection client={client} />
              <Separator />
              {client.opportunities && client.opportunities.length > 0 && (
                <OpportunitiesSummary opportunities={client.opportunities} />
              )}
              {client.latest_survey && (
                <>
                  <Separator />
                  <ClientSurveySummary client={client} />
                </>
              )}
              <Separator />
              <CommunicationHistorySection
                communications={client.communications ?? []}
              />
              <Separator />
              <ReminderHistorySection reminders={client.reminders ?? []} />
            </div>
          </>
        )}
      </main>
    </div>
  )
}

function CompanyInfoCard({ client }: { client: ClientInfoPage }) {
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
              <span>{client.company.industry}</span>
            </div>
            <div>
              <span className="block text-sm text-muted-foreground">
                Address
              </span>
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
          </div>
          {client.notes && (
            <Alert>
              <Info />
              <AlertTitle>Note</AlertTitle>
              <AlertDescription>{client.notes}</AlertDescription>
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

function ClientInfoCard({ client }: { client: ClientInfoPage }) {
  return (
    <section>
      <Card>
        <CardHeader>
          <CardTitle>Client Information</CardTitle>
          <CardDescription>
            Client since {new Date(client.client_since).toDateString()}
          </CardDescription>
          <CardAction>
            {client.lead && (
              <Button variant="link" size="sm" asChild>
                <a href={`/admin/lead/${client.lead.id}`}>
                  <span>View Lead Profile</span>
                  <MoveUpRight />
                </a>
              </Button>
            )}
          </CardAction>
        </CardHeader>
        <CardContent className="grid grid-cols-2 gap-4">
          <div>
            <span className="block text-sm text-muted-foreground">Status</span>
            <Badge variant="secondary">{client.status}</Badge>
          </div>
          <div>
            <span className="block text-sm text-muted-foreground">
              Recent Activity
            </span>
            <span>{client.recent_activity?.toDateString()}</span>
          </div>
          <div className="flex items-center gap-1">
            <Avatar>
              <AvatarImage src={client.sales_representative.profileHref} />
              <AvatarFallback>
                {client.sales_representative.profileFallback}
              </AvatarFallback>
            </Avatar>
            <div>
              <span className="block text-sm text-muted-foreground">
                Sales Representative
              </span>
              <span>{client.sales_representative.name}</span>
            </div>
          </div>
          <div>
            <span className="block text-sm text-muted-foreground">
              Created At
            </span>
            <span>{new Date(client.created_at).toDateString()}</span>
          </div>
        </CardContent>
      </Card>
    </section>
  )
}

function ContactInfoSection({ client }: { client: ClientInfoPage }) {
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
        {client.contacts.map((contact, i) => (
          <Card key={i}>
            <CardHeader>
              <CardTitle>{contact.name}</CardTitle>
              <CardDescription>{contact.title}</CardDescription>
              <CardAction className="flex flex-wrap gap-2">
                {client.lead && (
                  <Button variant="link" size="sm" asChild>
                    <a href={`/admin/lead/${client.lead.id}`}>
                      View Lead Profile
                    </a>
                  </Button>
                )}
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

function ClientSurveySummary({ client }: { client: ClientInfoPage }) {
  const survey = client.latest_survey

  if (!survey) return null

  const score = survey.average_score ? Number(survey.average_score) : null

  return (
    <section>
      <Card>
        <CardHeader>
          <div className="flex items-center gap-2">
            <CardTitle>Latest Satisfaction Survey</CardTitle>
            <Badge variant="secondary">Completed</Badge>
          </div>
          <CardAction>
            <Button variant="link" size="sm" asChild>
              <Link
                to="/admin/satisfaction/$clientId"
                params={{ clientId: client.id.toString() }}
              >
                <span>View All Surveys</span>
                <MoveUpRight />
              </Link>
            </Button>
          </CardAction>
        </CardHeader>
        <CardContent>
          <div className="grid grid-cols-3 gap-4">
            <div>
              <span className="block text-sm text-muted-foreground">
                Average Score
              </span>
              <span className="text-2xl font-semibold">
                {score !== null ? score.toFixed(1) : "—"}
              </span>
            </div>
            <div>
              <span className="block text-sm text-muted-foreground">
                Completed At
              </span>
              <span>
                {survey.completed_at
                  ? new Date(survey.completed_at).toLocaleDateString()
                  : "—"}
              </span>
            </div>
            <div>
              <span className="block text-sm text-muted-foreground">Status</span>
              <Badge variant="default">{survey.status}</Badge>
            </div>
          </div>
        </CardContent>
      </Card>
    </section>
  )
}
