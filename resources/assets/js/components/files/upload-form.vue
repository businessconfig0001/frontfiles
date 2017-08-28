<template>
<div class="form-wrapper">
	<h3>File: <span>{{upload.name}}</span></h3>
	<p>
		<display-error :error="errors['title']"></display-error>
		<input type="text" name="title" id="title" class="form-control" placeholder="Title" v-model="upload.data.title"/>
	</p>
	<p>
		<display-error :error="errors['title']"></display-error>
		<textarea name="description" id="description" class="form-control" placeholder="Description" v-model="upload.data.description"></textarea>
		
	</p>
	<p>
		<display-error :error="errors['title']"></display-error>
		<tag-input placeholder="#What" class="form-control" :tags="upload.data.what"></tag-input>
		
	</p>
	<p>
		<display-error :error="errors['title']"></display-error>
		<tag-input placeholder="#Who" class="form-control" :tags="upload.data.who"></tag-input>			
	</p>
	<p>
		<display-error :error="errors['title']"></display-error>
		<input type="" ref="where" name="where" id="where" class="form-control" placeholder="#Where" v-model="upload.data.where" @focus.once="initPlace"/>
		
	</p>
	<p>
		<display-error :error="errors['title']"></display-error>
		<input type="text" name="when" id="when" class="form-control" placeholder="#When" onfocus="(this.type='date')" v-model="upload.data.when"/>
	</p>
	<p>
		<display-error :error="errors['title']"></display-error>
		<textarea name="why" id="why" class="form-control" placeholder="#Why" v-model="upload.data.why"></textarea>
		
	</p>
	<p>
		<display-error :error="upload.errors['drive']"></display-error>
		<div class="radio" v-show="dropbox">
			<input type="radio" name="drive" value="dropbox" class="form-control"  id="dropbox" v-model="upload.data.drive" checked>
		 	<label class="btn btn-secondary" for="dropbox">Dropbox</label>
		 			
		</div>
			
		
	</p>

</div>

</template>

<script>
import  displayError from './../inputs/display-error'
export default {

	name: 'upload-form',
	components:{
		displayError
	},
	props:{
		upload:{
			required:true,
			type:Object
		},
		errors:{
			required:false,
			type:Object
		},
		dropbox:{
		}
	},
	data () {
		return {

		};
	},
	methods:{
		initPlace(event){
				let placebox=new google.maps.places.Autocomplete(event.target)
				try{
					placebox.addListener('place_changed',() => {
						console.log(placebox.getPlace())
						this.upload.data.where = placebox.getPlace().formatted_address
					})	
				}
				catch(e){}	
		}
	},
	watch:{
		errors(){
			console.log('errors changed')
		}
	}
};
</script>

<style lang="scss" scoped>
.form-wrapper{
	
	h3{
		padding:1rem 0;
		color:blue;
	}

	.radio{
		display:flex;

		.btn-secondary{
			background-color:#eee;
			flex:1;
			border:2px solid #eee;
		}

		input[type='radio']{
			visibility:hidden;
			flex:1;
			margin: 0px;

			&:checked  + label{
				color:blue;
				background-color:white;
				border:2px solid blue;
			
			}
		}		
	}
}

</style>