import api from "@/lib/api"
import { useQuery } from "@tanstack/react-query"

export default function useCompanies() {
  return useQuery({
    queryKey: ["companies"],
    queryFn: async () => {
      const response = await api.get("/api/companies")
      return response.data.data as { id: number; name: string; industry: string; is_client: boolean }[]
    },
  })
}
