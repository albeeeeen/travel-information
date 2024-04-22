import {defineStore} from "pinia";

export const useDestinationStore = defineStore('DestinationStore', {
    state: () => {
        return {
            destinationData: null
        }
    },
    actions: {
        fetchAllDestinations() {
            axios.get('/rest/getAllDestinations')
        }
    }
});