import { z } from "zod"

export type SalesRepresentative = {
  id: number
  name: string
}

export type CompanyOption = {
  id: number
  name: string
  industry: string
}

export type LeadOption = {
  id: number
  company: {
    id: number
    name: string
  }
}

export type CreateOpportunityPayload = {
  company_id: number
  lead_id: number | null
  assigned_to_id: number
  title: string
  description: string
  estimated_contract_value: number | null
  expected_close_date: string | null
}

export const createOpportunitySchema = z.object({
  company_id: z.number().int().positive("Select a company"),
  lead_id: z.number().int().positive().nullable().optional(),
  assigned_to_id: z.number().int().positive("Select a sales representative"),
  title: z.string().min(1, "Opportunity title is required").max(255),
  description: z.string().max(5000).optional().default(""),
  estimated_contract_value: z.coerce.number().nullable().optional(),
  expected_close_date: z.string().nullable().optional(),
})

export type CreateOpportunityFormValues = z.infer<typeof createOpportunitySchema>
