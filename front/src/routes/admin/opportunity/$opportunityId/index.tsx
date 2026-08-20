import {
  Avatar,
  AvatarFallback,
  AvatarImage,
} from "@/components/ui/avatar"
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
  CheckCircle2,
  Info,
  Mail,
  MoveUpRight,
  Pencil,
  Phone,
  Plus,
  Trash,
} from "lucide-react"
import useOpportunityDetailsQuery from "./-useOpportunityDetailsQuery"
import { useWinOpportunity } from "./-useWinOpportunity"
import { Spinner } from "@/components/ui/spinner"
import {
  Alert,
  AlertAction,
  AlertDescription,
  AlertTitle,
} from "@/components/ui/alert"

export type OpportunityInfoPage = {
  id: number
  title: string
  stage: "initial_contact" | "discussion" | "proposal" | "negotiation" | "contract_processing" | "won" | "lost"
  description: string
  company: {
    name: string
  }
  lead: {
    id: number
    status: "new" | "qualified" | "converted" | "disqualified"
    company: {
      id: number
      name: string
    }
  } | null
  assigned_to: {
    id: number
    name: string
  }
  estimated_contract_value: number | null
  expected_close_date: string | null
  lost_reason: string | null
  manpower_requirement: number | null
  created_at: string
  contacts: {
    id: number
    name: string
    title: string
    email: string
    phone: string
    is_primary: boolean
  }[]
}

export const Route = createFileRoute("/admin/opportunity/$opportunityId/")({
  component: RouteComponent,
})

function RouteComponent() {
  const router = useRouter()
  const { opportunityId } = Route.useParams()
  const query = useOpportunityDetailsQuery(opportunityId)
  const opportunity = query.data!

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
            <div className="mt-6 flex flex-col gap-6">
              <OpportunityInfoCard opportunity={opportunity} opportunityId={Number(opportunityId)} />
              {opportunity.lead && (
              <>
                <Separator />
                <LeadInfoCard opportunity={opportunity} />
              </>
            )}
            <Separator />
            <ContactInfoSection opportunity={opportunity} />
          </div>
        )}
      </main>
    </div>
  )
}

function OpportunityInfoCard({
  opportunity,
  opportunityId,
}: {
  opportunity: OpportunityInfoPage
  opportunityId: number
}) {
  const canWin = opportunity.stage === "contract_processing"
  const winMutation = useWinOpportunity(opportunityId)

  return (
    <section>
      <Card>
        <CardHeader>
          <div className="flex flex-col gap-1">
            <div className="flex items-center gap-2">
              <CardTitle>{opportunity.company.name}</CardTitle>
              <Badge variant="secondary">{opportunity.stage}</Badge>
            </div>
            <CardDescription>
              {opportunity.title}
            </CardDescription>
          </div>
          <CardAction className="flex gap-2">
            {canWin && (
              <Button
                variant="default"
                size="icon"
                onClick={() => winMutation.mutateAsync()}
                disabled={winMutation.isPending}
              >
                <CheckCircle2 />
              </Button>
            )}
            <Button variant="outline" size="icon">
              <Pencil />
            </Button>
          </CardAction>
        </CardHeader>
        <CardContent className="grid grid-cols-2 gap-4">
          <div className="col-span-2">
            <span className="block text-sm text-muted-foreground">
              Description
            </span>
            <span>{opportunity.description}</span>
          </div>
          <div>
            <span className="block text-sm text-muted-foreground">
              Estimated Contract Value
            </span>
            <span>
              {opportunity.estimated_contract_value
                ? new Intl.NumberFormat("en-PH", {
                    style: "currency",
                    currency: "PHP",
                    minimumFractionDigits: 0,
                  }).format(opportunity.estimated_contract_value)
                : "—"}
            </span>
          </div>
          <div>
            <span className="block text-sm text-muted-foreground">
              Expected Close Date
            </span>
            <span>
              {opportunity.expected_close_date
                ? new Date(
                    opportunity.expected_close_date
                  ).toLocaleDateString()
                : "—"}
            </span>
          </div>
          <div>
            <span className="block text-sm text-muted-foreground">
              Manpower Requirement
            </span>
            <span>
              {opportunity.manpower_requirement
                ? `${opportunity.manpower_requirement} people`
                : "—"}
            </span>
          </div>
          <div>
            <span className="block text-sm text-muted-foreground">
              Created At
            </span>
            <span>{new Date(opportunity.created_at).toDateString()}</span>
          </div>
          {opportunity.lost_reason && (
            <div className="col-span-2">
              <Alert variant="destructive">
                <Info />
                <AlertTitle>Lost Reason</AlertTitle>
                <AlertDescription>
                  {opportunity.lost_reason}
                </AlertDescription>
              </Alert>
            </div>
          )}
          <div className="flex items-center gap-1">
            <Avatar>
              <AvatarImage src={opportunity.assigned_to.name} />
              <AvatarFallback>
                {opportunity.assigned_to.name
                  .split(" ")
                  .map((n) => n[0])
                  .join("")}
              </AvatarFallback>
            </Avatar>
            <div>
              <span className="block text-sm text-muted-foreground">
                Sales Representative
              </span>
              <span>{opportunity.assigned_to.name}</span>
            </div>
          </div>
        </CardContent>
      </Card>
    </section>
  )
}

function LeadInfoCard({ opportunity }: { opportunity: OpportunityInfoPage }) {
  if (!opportunity.lead) return null

  return (
    <section>
      <Card>
        <CardHeader>
          <CardTitle>Origin Lead</CardTitle>
          <CardDescription>
            {opportunity.lead.company.name}
          </CardDescription>
        </CardHeader>
        <CardContent className="grid grid-cols-2 gap-4">
          <div>
            <span className="block text-sm text-muted-foreground">
              Lead Status
            </span>
            <Badge variant="secondary">{opportunity.lead.status}</Badge>
          </div>
          <div>
            <Button variant="link" className="p-0" asChild>
              <a
                href={`/admin/lead/${opportunity.lead.id}`}
                target="_blank"
                rel="noreferrer"
              >
                View Lead <MoveUpRight />
              </a>
            </Button>
          </div>
        </CardContent>
      </Card>
    </section>
  )
}

function ContactInfoSection({
  opportunity,
}: {
  opportunity: OpportunityInfoPage
}) {
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
        {opportunity.contacts.map((contact, i) => (
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
