<template>
<div class="form-wrapper">
	<h3>File: <span>{{upload.name}}</span></h3>
	<p>
		<display-error :error="upload.errors.has('title') ? form.errors.get('title') : false"></display-error>
		<input type="text" name="title" id="title" class="form-control" placeholder="Title" v-model="upload.data.title"/>
	</p>
	<p>
		<display-error :error="upload.errors.has('description') ? form.errors.get('description') : false"></display-error>
		<textarea name="description" id="description" class="form-control" placeholder="Description" v-model="upload.data.description"></textarea>
		
	</p>
	<p>
		<display-error :error="upload.errors.has('what') ? form.errors.get('what') : false"></display-error>
		<tag-input placeholder="#What" :tags="upload.data.what"></tag-input>
		
	</p>
	<p>
		<display-error :error="upload.errors.has('who') ? form.errors.get('who') : false "></display-error>
		<tag-input placeholder="#Who" :tags="upload.data.who"></tag-input>			
	</p>
	<p>
		<display-error :error="upload.errors.has('where') ? form.errors.get('where') : false"></display-error>
		<input type="" ref="where" name="where" id="where" class="form-control" placeholder="#Where" v-model="upload.data.where" @focus.once="initPlace"/>
		
	</p>
	<p>
		<display-error :error="upload.errors.has('when') ? form.errors.get('when') : false"></display-error>
		<input type="text" name="when" id="when" class="form-control" placeholder="#When" onfocus="(this.type='date')" v-model="upload.data.when"/>
	</p>
	<p>
		<display-error :error="upload.errors.has('why') ? form.errors.get('why') : false"></display-error>
		<textarea name="why" id="why" class="form-control" placeholder="#Why" v-model="upload.data.why"></textarea>
		
	</p>
	<p>
		<display-error :error="upload.errors['drive']"></display-error>
		<input type="radio" name="drive" value="azure" class="form-control" v-model="upload.data.drive" checked> Azure<br>
		<input type="radio" name="drive" value="google" class="form-control" v-model="upload.data.drive"> Google Drive<br>
		<input type="radio" name="drive" value="dropbox" class="form-control" v-model="upload.data.drive"> Dropbox
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
						this.upload.data.where = placebox.getPlace().address_components[0].long_name
					})	
				}
				catch(e){}	
		}
	}
};
</script>

<style lang="css" scoped>
</style>