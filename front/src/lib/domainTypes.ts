export type UserRole = "admin" | "manager" | "sales_rep"

export type User = {
  id: number
  firstName: string
  lastName: string
  email: string
  role: UserRole
  isActive: boolean
}

export type Company = {
  id: number
  name: string
  industry: string
  address: string
  phone: string
  email: string
  website: string | null
  createdAt: Date
  updatedAt: Date
}

export type Contact = {
  id: number
  companyId: number
  firstName: string
  lastName: string
  title: string
  email: string
  phone: string
  isPrimary: boolean
  createdAt: Date
  updatedAt: Date
}

export type LeadStatus = "new" | "qualified" | "converted" | "disqualified"

export type Lead = {
  id: number
  companyId: number
  assignedToId: number
  source: string
  status: LeadStatus
  createdAt: Date
  updatedAt: Date
}

export type ClientStatus = "active" | "inactive"

export type Client = {
  id: number
  companyId: number
  assignedToId: number
  clientSince: Date
  status: ClientStatus
  createdAt: Date
  updatedAt: Date
}
