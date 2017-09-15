<template>
<section class="profile-container">
		<div class="container">
			<div class="col-xs-12">
				<div class="profile-picture col-xs-2">
					<img :src="user.avatar" />
				</div>

				<div class="profile-content col-xs-9">
					<div class="row">
						<div class="col-xs-12">
							<h1 class="title">{{ user.first_name + " " + user.last_name }}<a v-if="current" @click.prevent="show=true" class="edit"><img src="/images/edit-btn.png" alt=""></a></h1>
							<div class="box">
								<h2 class=" subtitle location">{{ user.location }}</h2>
								<p class="txt-small">{{ user.bio }}</p>
							</div>
						</div>
						
					</div>

				</div>
			</div>
		</div>
		<div class="container files">
			<files-display :_files="files" :active="current"></files-display>
		</div>
		<profile-edit v-if="current" :userprop="user" :show="show" @close="close"></profile-edit>
</section>
</template>

<script>
import filesDisplay from './../files/files-display'
import profileEdit from './../modals/profile-edit'
export default {

	name: 'user-profile',
	components:{
		filesDisplay,
		profileEdit
	},
	props:{
		user:{
			required:true,
			type:Object
		},
		files:{
			required:true,
			type:Array
		},
		activeprop:{
			required:false,
			default:() => false
		},
		role:{
			
		}
	},
	data () {
		return {
			current:false,
			show:false,
			active:JSON.parse(JSON.stringify(this.activeprop))
		}
	},
	mounted(){
		scroll(0,0)
		this.user.role=this.role[0]
		let modalName='first_login'
		if(!localStorage.getItem(modalName))this.$store.commit('openModal',modalName)
		if(this.active){
			this.current = this.active.id === this.user.id
		}
		else this.current=false

	},
	methods:{
		close(res){
			this.show=false
			if(!res){
				console.log(false)
			}
			else{
				console.log(res)
				this.active=res
			}
		}
	}
}
</script>

<style lang="scss" scoped>
.title{
	font-size:1.8em !important;
}
.profile-picture{
	padding-top:3rem;
}
.edit{
	img{
		width:25px;	
		margin-left:1rem;
	}
	
}
.files{
	margin-top:2rem;
}
</style>