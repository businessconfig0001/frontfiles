<template>
<div>
	<div v-if="show" class="modal-background clearfix">
		<div class="modal-wrapper modal-content profile-edit">
			<h2>Edit profile</h2>
			<div class="form-wrapper">
				<p>
					<display-error :error="errors['first_name']"></display-error>
					<input type="text" name="first_name" id="first_name" class="form-control" placeholder="First name" v-model="user.first_name"/>
				</p>
				<p>
					<display-error :error="errors['last_name']"></display-error>
					<input name="last_name" id="last_name" class="form-control" placeholder="Last name" v-model="user.last_name"/>
					
				</p>
				<p>
					<display-error :error="errors['avatar']"></display-error>
					<file-input class="file-input" :options="{ name:'avatar',accept:'image',label:'upload picture' }" @change="avatar"></file-input>
				</p>
				<p>
					<display-error :error="errors['bio']"></display-error>
					<textarea name="bio" id="bio" class="form-control" placeholder="bio" v-model="user.bio"></textarea>	
				</p>
				<p>
					<display-error :error="errors['location']"></display-error>
					<input type="text" name="location" id="location" class="form-control" placeholder="Location" v-model="user.location" @focus.once="initPlace"/>
				</p>

				<div class="register-radio">
					<display-error :error="errors['role']"></display-error>
                    <div class="radio-wrapper">
                       <input type="radio" name="type" value="user" class="form-control" id="indu" v-model="user.role" checked>
                        <label for="indu">Individual</label> 
                    </div>
                    <div>
                        <input id="coll" type="radio" name="type" value="corporative" class="form-control" v-model="user.role">
                        <label  for="coll">Collective</label>
                    </div>
                 </div>	
				
                <a class="btn btn-primary" @click.prevent="edit">Save</a>
				<a class="btn btn-secondary" @click.prevent="close">Cancel</a>
            </div>

			<a href="#" class="close" @click.prevent="close">&#10005</a>
		</div>
	</div>
</div>
</template>

<script>
import fileInput from './../inputs/file-input'
import displayError from './../inputs/display-error'
export default {

	name: 'file-modal',
	props:{
		userprop:{
			required:true,
			type:Object
		},
		show:{
			required:true,
			type:Boolean
		},

	},
	components:{
		fileInput,
		displayError
	},
	data () {
		return {
			errors:[],
			avatar:false,
			user:JSON.parse(JSON.stringify(this.userprop))
		}
	},
	watch:{
		show(){
			scroll(0,0)
			if(this.show)this.user=JSON.parse(JSON.stringify(this.userprop))
		}
	},
	methods:{
		initPlace(event){
			let placebox=new google.maps.places.Autocomplete(event.target)
			try{
				placebox.addListener('place_changed',() => {
					this.user.location = placebox.getPlace().formatted_address
				})	
			}
			catch(e){}	
		},
		close(){
			this.$emit('close',false)
		},
		edit(){
			let f=new FormData()
			f.append('first_name',this.user.first_name)
			f.append('last_name',this.user.last_name)
			if(this.avatar)f.append('avatar',this.avatar)
			f.append('bio',this.user.bio)
			f.append('location',this.user.location)
			f.append('role',this.user.role)

			f.append('_method','patch')

			axios.post(window.location.origin + '/profile',f)
				.then(res =>{
					this.$emit('close',this.user)
					
				})
				.catch(res => this.errors=res.response.data)


		},
		avatar(data){
			this.avatar= data
		}
	}
}
</script>

<style lang="scss" scoped>
.modal-background{
	transition: .4s ease-out;
	position:absolute;
	z-index:1000;
	background-color:rgba(0,0,0,0.5);
	width: 100vw;
    height: 100vh;
    top: 0;
    left:0;


	.modal-wrapper.modal-content{
		width:35%;
		background-color:white;
		padding:3rem;
		position:absolute;
		left:50%;
		top: 20%;
  		transform: translate(-50%, -20%);
  		border-radius:0;
  		max-height:80vh;
  		overflow-y:scroll;

  		h2{
  			font-size:2rem;
  			text-align:center;
  		}

  		p, .register-radio{
  			margin:1rem;
  			width:100%;
  		}

  		.btn{
  			margin-top:1rem;
  			width:40%;
  			margin-left:30%;
  		}

  		.register-radio{
  			width:80%;
  			margin-left:10%;

			.radio-wrapper{
				float:left;
				width: 50%;
				display: flex;

				label{
					flex:1;
					padding:1rem;
					text-align:center;
					background-color:#eee;
					cursor:pointer;
				}
				input[type='radio']{
					visibility:hidden;
					margin: 0px;
					clip: rect(0, 0, 0, 0);
		    		height: 1px;
		    		width: 1px;
				

					&:checked  + label{
						color:white;
						background-color:blue;
					
					}
				}
	}

		
}


		.modal-button{
			width:60%;
			margin:.5rem;
			margin-left:20%;
		}

		
		.close{
			padding:1rem;
			position:absolute;
			top:0;
			right:0;
		}

	
	}
}

</style>
