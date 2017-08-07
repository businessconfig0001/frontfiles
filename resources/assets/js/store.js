/**
 * Vuex data store implementation
*/
import Vuex from 'vuex'

export default new Vuex.Store({
	state: {
		showModal:false,
		
	},
	actions: {

	},
	mutations: {
		openModal(state){
			state.showModal = true
		},
		closeModal(state){
			state.showModal = false
		}


	},
	getters: {

	}
})
