import api from "@/lib/api"
import { useQuery } from "@tanstack/react-query"

export default function useSalesRepresentatives() {
  return useQuery({
    queryKey: ["sales-representatives"],
    queryFn: async () => {
      const response = await api.get("/api/sales-representatives")
      return response.data.data as { id: number; name: string }[]
    },
  })
}
