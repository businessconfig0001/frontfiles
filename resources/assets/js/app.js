
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');




/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//files
Vue.component('drag-n-drop', require('./components/files/drag-n-drop.vue'))
Vue.component('files-display',require('./components/files/files-display.vue'))
Vue.component('file-detail',require('./components/files/file-detail.vue'))
Vue.component('vue-slider',require('./components/files/vue-slider.vue'))


//inputs
Vue.component('tag-input',require('./components/inputs/tag-input.vue'))
Vue.component('file-input',require('./components/inputs/file-input.vue'))
Vue.component('places-input',require('./components/inputs/places-input.vue'))


//modals
Vue.component('modal-container',require('./components/modals/modal-container.vue'))
Vue.component('profile-modal',require('./components/modals/profile-modal.vue'))
Vue.component('register-modal',require('./components/modals/register-modal.vue'))


//profiles
Vue.component('user-profile',require('./components/profiles/user-profile.vue'))
Vue.component('user-listing',require('./components/profiles/user-listing.vue'))

//map
Vue.component('map-component',require('./components/maps/map-component.vue'))

import VueCarousel from 'vue-carousel'
Vue.use(VueCarousel)
/**
 * Vuex data store implementation
*/
import Vuex from 'vuex'


Vue.use(Vuex)

const store = new Vuex.Store({
	state: {
		showModal:false,
		showEdit:'',
		modalData:'',
		progress:0,
		previousProgress:0,
		whoTags:[],
		whatTags:[],
		enter:false
		
	},
	actions: {

	},
	mutations: {
		openModal(state,text){
			state.showModal = true
			state.modalData = text
		},
		closeModal(state){
			state.showModal = false
		},
		editModal(state,name){
			state.showEdit=name
		},
		closeEdit(state){
			state.showEdit=''
		},
		resetProgress(state){
			state.progress = 0
		},
		addProgress(state,p){
			state.progress +=p
			state.previousProgress=p
		},
		changeWhoTags(state,tags){
			state.whoTags=tags
		},
		changeWhatTags(state,tags){
			state.whatTags=tags
		},
		down(state){
			state.enter=true
		},
		up(state){
			state.enter=false
		}



	},
	getters: {

	}
})

import { getQuery } from './helpers'
const app = new Vue({
    el: '#app',
    store,
    data(){
    	return {
    		allow:false,
    		options:{
    			show:false
    		},
    		regOptions:{
    			show:false,
    		},
    		ethics:false
    	}	
    },
    mounted(){
    	if(getQuery('code') === 'secret')this.allow=true
     	else this.options.show=true
    	window.addEventListener('keydown',e => {
    		if(e.keyCode === 13){
    			this.$store.commit('down')
    		}
    	})

    	window.addEventListener('keyup',e =>{
    		if(e.keyCode === 13){
    			this.$store.commit('up')
    		}
    	})

    },
	methods:{
		modal(){
			console.log('click')
			this.$store.commit('openModal','')
		},
		submit(name){
			let form=document.getElementById(name)
			form.submit()
		},
	},
});
