import { graphService } from "@/services/graph.service.js";

const actions = {
    getExport() {
        graphService.getExport()
    }
};
export const graph = {
    namespaced: true,
    actions,
};
