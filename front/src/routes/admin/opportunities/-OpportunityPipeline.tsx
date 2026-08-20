import { Badge } from "@/components/ui/badge"
import { Button } from "@/components/ui/button"
import { Card, CardContent } from "@/components/ui/card"
import { ScrollArea, ScrollBar } from "@/components/ui/scroll-area"
import { useNavigate, Link } from "@tanstack/react-router"
import { formatCurrency } from "@/lib/utils"
import { CheckCircle2, Plus } from "lucide-react"
import { useMutation, useQueryClient } from "@tanstack/react-query"
import api from "@/lib/api"
import useOpportunitiesQuery from "./-useOpportunitiesQuery"

const stages = [
  { key: "initial_contact", label: "Initial Contact" },
  { key: "discussion", label: "Discussion" },
  { key: "proposal", label: "Proposal" },
  { key: "negotiation", label: "Negotiation" },
  { key: "contract_processing", label: "Contract Processing" },
  { key: "won", label: "Won" },
  { key: "lost", label: "Lost" },
]

export type OpportunityPipelineCard = {
  id: number
  title: string
  stage:
    | "initial_contact"
    | "discussion"
    | "proposal"
    | "negotiation"
    | "contract_processing"
    | "won"
    | "lost"
  company: {
    id: number
    name: string
    industry: string
  }
  assigned_to: {
    id: number
    name: string
  }
  estimated_contract_value: number | null
  expected_close_date: string | null
}

export default function OpportunityPipeline() {
  const navigate = useNavigate()
  const query = useOpportunitiesQuery()
  const data = query.data
  const queryClient = useQueryClient()

  const winMutation = useMutation({
    mutationFn: async (opportunityId: number) => {
      const response = await api.post(`/api/opportunities/${opportunityId}/win`)
      return response.data.data
    },
    onSuccess: () => {
      queryClient.invalidateQueries({
        queryKey: ["opportunities"],
      })
    },
  })

  const grouped = stages.reduce(
    (acc, stage) => {
      acc[stage.key] = data?.filter((o) => o.stage === stage.key) ?? []
      return acc
    },
    {} as Record<string, OpportunityPipelineCard[]>
  )

  return (
    <ScrollArea className="whitespace-nowrap">
      <div className="flex gap-6 p-4">
        {stages.map((stage) => (
          <div
            key={stage.key}
            className="flex w-80 shrink-0 flex-col gap-3 px-3"
          >
            <div className="flex items-center justify-between">
              <h3 className="font-medium">{stage.label}</h3>
              <Badge variant="secondary">
                {grouped[stage.key]?.length ?? 0}
              </Badge>
            </div>
            {stage.key === "initial_contact" && (
              <Button asChild className="w-full">
                <Link to="/admin/opportunity/create">
                  <Plus className="mr-2 size-4" />
                  Create opportunity
                </Link>
              </Button>
            )}
            <ScrollArea className="h-[calc(100vh-220px)]">
              <div className="flex flex-col gap-3 px-2 py-3">
                {grouped[stage.key]?.map((opportunity) => (
                  <Card
                    key={opportunity.id}
                    className="cursor-pointer hover:border-primary/50"
                    onClick={() =>
                      navigate({
                        to: "/admin/opportunity/$opportunityId",
                        params: {
                          opportunityId: opportunity.id.toString(),
                        },
                      })
                    }
                  >
                    <CardContent className="px-4">
                      <div className="flex flex-col gap-2">
                        <span className="font-medium">{opportunity.title}</span>
                        <span className="text-xs text-muted-foreground">
                          {opportunity.company.name}
                        </span>
                        <div className="flex items-center justify-between text-xs">
                          <span>{opportunity.assigned_to.name}</span>
                          {opportunity.estimated_contract_value && (
                            <span className="font-medium">
                              {formatCurrency(
                                opportunity.estimated_contract_value
                              )}
                            </span>
                          )}
                        </div>
                        {opportunity.expected_close_date && (
                          <span className="text-xs text-muted-foreground">
                            Close:{" "}
                            {new Date(
                              opportunity.expected_close_date
                            ).toLocaleDateString()}
                          </span>
                        )}
                        {opportunity.stage === "contract_processing" && (
                          <Button
                            variant="default"
                            size="sm"
                            className="mt-2 w-full"
                            onClick={(e) => {
                              e.stopPropagation()
                              winMutation.mutate(opportunity.id)
                            }}
                            disabled={winMutation.isPending}
                          >
                            <CheckCircle2 className="mr-2 size-4" />
                            Mark as Won
                          </Button>
                        )}
                      </div>
                    </CardContent>
                  </Card>
                ))}
              </div>
              <ScrollBar orientation="vertical" />
            </ScrollArea>
          </div>
        ))}
      </div>
      <ScrollBar orientation="horizontal" />
    </ScrollArea>
  )
}
