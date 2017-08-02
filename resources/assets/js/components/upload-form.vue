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
		<tag-input placeholder="#What" :tags="upload.data.what"></tag-input>
		
	</p>
	<p>
		<display-error :error="errors['title']"></display-error>
		<tag-input placeholder="#Who" :tags="upload.data.who"></tag-input>			
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
		<input type="radio" name="drive" value="nothing" class="form-control" v-model="upload.data.drive" checked> Default
		<input type="radio" name="drive" value="dropbox" class="form-control" v-model="upload.data.drive"> Dropbox (please configure it first)
	</p>

</div>

</template>

<script>
import  displayError from './display-error'
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

<style lang="css" scoped>
</style>