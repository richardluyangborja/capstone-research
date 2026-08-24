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
  AlertTriangle,
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
import { useUpdateLeadStatus } from "./-useUpdateLeadStatus"
import { Spinner } from "@/components/ui/spinner"
import OpportunitiesSummary, {
  type OpportunityStage,
  type OpportunitySummary,
} from "@/components/opportunities-summary"
import {
  Alert,
  AlertAction,
  AlertDescription,
  AlertTitle,
} from "@/components/ui/alert"
import { StageTransitionModal } from "@/components/stage-transition-modal"
import type { StatusHistoryEntry } from "@/components/stage-transition-modal"
import { type ReminderEntry } from "@/components/reminders-history"
import {
  CommunicationHistorySection,
  type CommunicationEntry,
} from "@/components/communication-history"
import { ReminderHistorySection } from "@/components/reminders-history"
import { useState } from "react"

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
  opportunities?: OpportunitySummary[]
  status_histories?: StatusHistoryEntry[]
  communications?: CommunicationEntry[]
  reminders?: ReminderEntry[]
}

export const Route = createFileRoute("/admin/lead/$leadId/")({
  component: RouteComponent,
})

export type LeadStatus = "new" | "qualified" | "disqualified" | "converted"

export const leadStatusLabels: Record<LeadStatus, string> = {
  new: "New",
  qualified: "Qualified",
  disqualified: "Disqualified",
  converted: "Converted",
}

export const leadStatusVariant: Record<
  LeadStatus,
  "default" | "secondary" | "destructive"
> = {
  new: "secondary",
  qualified: "default",
  disqualified: "destructive",
  converted: "default",
}

export const leadStatusTransitions: Record<
  LeadStatus,
  { label: string; value: string }[]
> = {
  new: [
    { label: "Qualify Lead", value: "qualified" },
    { label: "Convert to Client", value: "converted" },
    { label: "Disqualify Lead", value: "disqualified" },
  ],
  qualified: [
    { label: "Convert to Client", value: "converted" },
    { label: "Disqualify Lead", value: "disqualified" },
  ],
  disqualified: [],
  converted: [],
}

const qualificationStages: OpportunityStage[] = [
  "proposal",
  "negotiation",
  "contract_processing",
]

function shouldShowQualificationAlert(lead: LeadInfoPage): boolean {
  if (lead.status !== "new") return false
  if (!lead.opportunities) return false
  return lead.opportunities.some((opp) =>
    qualificationStages.includes(opp.stage)
  )
}

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
                    <Badge
                      variant={leadStatusVariant[lead.status as LeadStatus]}
                    >
                      {leadStatusLabels[lead.status as LeadStatus]}
                    </Badge>
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
              {lead.status_histories && lead.status_histories.length > 0 && (
                <StatusHistorySection histories={lead.status_histories} />
              )}
              <Separator />
              <ContactInfoSection lead={lead} />
              <Separator />
              {lead.opportunities && lead.opportunities.length > 0 && (
                <OpportunitiesSummary opportunities={lead.opportunities} />
              )}
              <Separator />
              <CommunicationHistorySection
                communications={lead.communications ?? []}
              />
              <Separator />
              {lead.status === "converted" &&
                lead.reminders?.some((r) => r.status === "pending") && (
                  <Alert variant="destructive">
                    <AlertTriangle />
                    <AlertTitle>Pending Reminders on Converted Lead</AlertTitle>
                    <AlertDescription>
                      This lead has been converted to a client, but still has
                      pending reminders. These reminders should be marked as
                      incomplete.
                    </AlertDescription>
                  </Alert>
                )}
              <ReminderHistorySection reminders={lead.reminders ?? []} />
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
  const status = lead.status as LeadStatus
  const statusMutation = useUpdateLeadStatus(lead.id)
  const transitions = leadStatusTransitions[status] ?? []
  const showQualificationAlert = shouldShowQualificationAlert(lead)

  const [modalOpen, setModalOpen] = useState(false)
  const [activeTransition, setActiveTransition] = useState<{
    label: string
    value: string
  } | null>(null)

  const handleTransitionClick = (transition: {
    label: string
    value: string
  }) => {
    setActiveTransition(transition)
    setModalOpen(true)
  }

  const handleModalSubmit = async (reason: string) => {
    if (!activeTransition) return
    await statusMutation.mutateAsync({
      to_status: activeTransition.value,
      reason,
    })
  }

  const modalTitle =
    activeTransition?.value === "disqualified"
      ? "Disqualify Lead"
      : activeTransition?.value === "converted"
        ? "Convert Lead to Client"
        : "Qualify Lead"

  const modalDescription =
    activeTransition?.value === "disqualified"
      ? "Provide details about why this lead was disqualified."
      : activeTransition?.value === "converted"
        ? "Provide details about this conversion. Pending follow-up reminders will be marked as incomplete."
        : "Provide details about why this lead is being qualified."

  return (
    <section>
      <Card>
        <CardHeader>
          <CardTitle>Lead Information</CardTitle>
          <CardDescription>
            Created at {new Date(lead.created_at).toDateString()}
          </CardDescription>
          <CardAction className="flex flex-wrap gap-2">
            {transitions.map((t) => (
              <Button
                key={t.value}
                size="sm"
                variant={t.value === "disqualified" ? "destructive" : "default"}
                onClick={() => handleTransitionClick(t)}
                disabled={statusMutation.isPending}
              >
                {t.label}
              </Button>
            ))}
          </CardAction>
        </CardHeader>
        <CardContent>
          {showQualificationAlert && (
            <Alert className="mb-4">
              <Info />
              <AlertTitle>Lead Status Update Recommended</AlertTitle>
              <AlertDescription>
                This lead still has a <strong>New</strong> status, but at least
                one opportunity has reached the Proposal stage or higher.
                Consider qualifying this lead to reflect the active engagement.
              </AlertDescription>
            </Alert>
          )}
          <div className="grid grid-cols-2 gap-4">
            <div>
              <span className="block text-sm text-muted-foreground">
                Status
              </span>
              <Badge variant={leadStatusVariant[status]}>
                {leadStatusLabels[status]}
              </Badge>
            </div>
            <div>
              <span className="block text-sm text-muted-foreground">
                Source
              </span>
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
          </div>
        </CardContent>
      </Card>

      <StageTransitionModal
        open={modalOpen}
        onOpenChange={setModalOpen}
        title={modalTitle}
        description={modalDescription}
        isPending={statusMutation.isPending}
        onSubmit={handleModalSubmit}
      />
    </section>
  )
}

function StatusHistorySection({
  histories,
}: {
  histories: StatusHistoryEntry[]
}) {
  return (
    <section>
      <h3 className="my-3 font-heading text-lg">Status History</h3>
      <div className="flex flex-col gap-3">
        {histories.map((h) => (
          <div key={h.id} className="border-l-2 border-muted pl-4">
            <div className="flex items-start justify-between">
              <div>
                <span className="text-sm font-medium">
                  {h.from_status
                    ? `${leadStatusLabels[h.from_status as LeadStatus]} → ${leadStatusLabels[h.to_status as LeadStatus]}`
                    : leadStatusLabels[h.to_status as LeadStatus]}
                </span>
                <span className="block text-xs text-muted-foreground">
                  {new Date(h.created_at).toLocaleString()}
                </span>
              </div>
              {h.user && (
                <span className="text-xs text-muted-foreground">
                  {h.user.name}
                </span>
              )}
            </div>
            {h.reason && <p className="mt-1 text-sm">{h.reason}</p>}
          </div>
        ))}
      </div>
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
