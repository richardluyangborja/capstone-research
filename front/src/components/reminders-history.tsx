/* eslint-disable react-refresh/only-export-components */
import { Avatar, AvatarFallback } from "@/components/ui/avatar"
import { Badge } from "@/components/ui/badge"
import { Button } from "@/components/ui/button"
import { Separator } from "@/components/ui/separator"
import { cn } from "@/lib/utils"
import {
  AlertCircle,
  AlertTriangle,
  Bell,
  Calendar,
  CheckCircle,
  ChevronDown,
  Clock,
  MoveUpRight,
  UserCheck,
} from "lucide-react"
import { Link } from "@tanstack/react-router"

export type ReminderPriority = "low" | "medium" | "high"

export type ReminderEntry = {
  id: number
  title: string
  description: string | null
  due_date: string
  priority: ReminderPriority
  is_completed: boolean
  completed_at: string | null
  assigned_to: { id: number; name: string } | null
  related_to_type: "lead" | "client" | "opportunity"
  related_to_id: number
  related_to_name: string
  company: { id: number; name: string; industry: string }
  created_at: string
}

export const reminderPriorityLabels: Record<ReminderPriority, string> = {
  low: "Low",
  medium: "Medium",
  high: "High",
}

export const reminderPriorityIcons: Record<
  ReminderPriority,
  React.ElementType
> = {
  low: Clock,
  medium: AlertCircle,
  high: AlertTriangle,
}

export const reminderPriorityVariant: Record<
  ReminderPriority,
  "default" | "secondary" | "destructive" | "outline"
> = {
  low: "secondary",
  medium: "default",
  high: "destructive",
}

export const relatedTypeIcons: Record<
  "lead" | "client" | "opportunity",
  React.ElementType
> = {
  lead: UserCheck,
  client: Bell,
  opportunity: Calendar,
}

export function ReminderPriorityBadge({
  priority,
}: {
  priority: ReminderPriority
}) {
  const Icon = reminderPriorityIcons[priority]
  return (
    <Badge
      variant={reminderPriorityVariant[priority]}
      className="flex items-center gap-1 text-xs"
    >
      <Icon size={10} />
      <span>{reminderPriorityLabels[priority]}</span>
    </Badge>
  )
}

export function ReminderStatusBadge({ completed }: { completed: boolean }) {
  return (
    <Badge
      variant={completed ? "secondary" : "outline"}
      className="flex items-center gap-1 text-xs"
    >
      {completed ? (
        <>
          <CheckCircle size={10} />
          <span>Completed</span>
        </>
      ) : (
        <>
          <Clock size={10} />
          <span>Pending</span>
        </>
      )}
    </Badge>
  )
}

function isOverdue(dueDateString: string, isCompleted: boolean): boolean {
  if (isCompleted) return false
  const due = new Date(dueDateString)
  const now = new Date()
  return due < now
}

export function ReminderHistorySection({
  reminders,
}: {
  reminders: ReminderEntry[]
}) {
  if (!reminders || reminders.length === 0) {
    return (
      <section>
        <h3 className="my-3 font-heading text-lg">Follow-up Reminders</h3>
        <p className="text-sm text-muted-foreground">No reminders yet.</p>
      </section>
    )
  }

  const sorted = [...reminders].sort((a, b) => {
    const aTime = new Date(a.due_date).getTime()
    const bTime = new Date(b.due_date).getTime()
    return aTime - bTime
  })

  const pending = sorted.filter((r) => !r.is_completed)
  const completed = sorted.filter((r) => r.is_completed)

  return (
    <section>
      <div className="flex items-center justify-between">
        <h3 className="my-3 font-heading text-lg">Follow-up Reminders</h3>
        <Badge variant="secondary" className="text-xs">
          {reminders.length} {reminders.length === 1 ? "reminder" : "reminders"}
        </Badge>
      </div>

      <div className="flex flex-col gap-3">
        {pending.map((r) => (
          <ReminderCard key={r.id} reminder={r} />
        ))}
        {pending.length === 0 && completed.length > 0 && (
          <p className="text-sm text-muted-foreground">
            All reminders completed.
          </p>
        )}
      </div>

      {completed.length > 0 && (
        <>
          <Separator className="my-3" />
          <details className="group">
            <summary className="flex cursor-pointer items-center gap-2 text-sm font-medium text-muted-foreground hover:text-foreground">
              <span>Completed ({completed.length})</span>
              <ChevronDown
                size={16}
                className="transition-transform group-open:rotate-180"
              />
            </summary>
            <div className="mt-3 flex flex-col gap-3">
              {completed.map((r) => (
                <ReminderCard key={r.id} reminder={r} />
              ))}
            </div>
          </details>
        </>
      )}
    </section>
  )
}

function ReminderCard({ reminder }: { reminder: ReminderEntry }) {
  const dueDate = new Date(reminder.due_date)
  const formattedDate = dueDate.toLocaleString([], {
    month: "short",
    day: "numeric",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  })
  const overdue = isOverdue(reminder.due_date, reminder.is_completed)
  const Icon = relatedTypeIcons[reminder.related_to_type]

  return (
    <div
      className={cn(
        "flex gap-3 rounded-lg border border-border p-3",
        overdue && "border-destructive/50 bg-destructive/5"
      )}
    >
      <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-muted">
        <Bell size={18} className="text-muted-foreground" />
      </div>

      <div className="flex-1 space-y-2">
        <div className="flex items-start justify-between gap-2">
          <div className="flex flex-wrap items-center gap-2">
            {overdue && (
              <Badge variant="destructive" className="text-xs">
                Overdue
              </Badge>
            )}
            <ReminderPriorityBadge priority={reminder.priority} />
            <ReminderStatusBadge completed={reminder.is_completed} />
          </div>
          <div className="flex items-center gap-1 text-xs text-muted-foreground">
            <Clock size={12} />
            <time dateTime={reminder.due_date}>{formattedDate}</time>
          </div>
        </div>

        <div className="flex items-center gap-2">
          <Icon size={14} className="text-muted-foreground" />
          <span className="text-sm font-medium">
            {reminder.related_to_type}: {reminder.related_to_name}
          </span>
        </div>

        <p className="text-sm font-medium">{reminder.title}</p>

        {reminder.description && (
          <p className="text-sm text-muted-foreground">
            {reminder.description}
          </p>
        )}

        <div className="flex items-center justify-between">
          <div className="flex items-center gap-1.5 text-xs text-muted-foreground">
            <Avatar className="h-5 w-5">
              <AvatarFallback className="text-xs">
                {reminder.assigned_to
                  ? reminder.assigned_to.name
                      .split(" ")
                      .map((n) => n[0])
                      .join("")
                      .slice(0, 2)
                  : "—"}
              </AvatarFallback>
            </Avatar>
            <span>{reminder.assigned_to?.name ?? "Unassigned"}</span>
          </div>

          <Button variant="link" size="sm" asChild>
            <Link
              to="/admin/reminders/$reminderId"
              params={{ reminderId: String(reminder.id) }}
            >
              <span>View</span>
              <MoveUpRight />
            </Link>
          </Button>
        </div>
      </div>
    </div>
  )
}
