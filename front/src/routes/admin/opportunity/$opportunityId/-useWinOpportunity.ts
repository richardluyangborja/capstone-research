import { useMutation, useQueryClient } from "@tanstack/react-query"
import api from "@/lib/api"

export function useWinOpportunity(opportunityId: number) {
  const queryClient = useQueryClient()

  return useMutation({
    mutationFn: async () => {
      const response = await api.post(
        `/api/opportunities/${opportunityId}/win`
      )
      return response.data.data
    },
    onSuccess: () => {
      queryClient.invalidateQueries({
        queryKey: ["opportunities"],
      })

      queryClient.invalidateQueries({
        queryKey: ["opportunity_details", opportunityId],
      })
    },
  })
}
