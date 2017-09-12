<template>
<div>
	<div v-if="show" class="modal-background clearfix">
		<div class="modal-wrapper modal-content col-md-4 file-edit">
			<ul class="fields">
				<li>
					<ul>
						<li>
							<display-error class="error" v-show="errors" :error="errors['title']"></display-error>
							<label for="title">Title</label>
							<input type="text" name="title" id="title" class="form-control" placeholder="Title" v-model="_file.title"/>
						</li>
						<li>
							<display-error class="error" v-show="errors" :error="errors['description']"></display-error>
							<label for="description">Description</label>
							<textarea name="description" id="description" class="form-control" placeholder="Description" v-model="_file.description"></textarea>
						</li>
						<li>
							<display-error class="error" v-show="errors" :error="errors['where']"></display-error>
							<label for="where">#Where:</label>
							 <input type="text" name="where"  class="form-control" @focus.once="initPlace" v-model="_file.where">
						</li>
						<li>
							<display-error class="error" v-show="errors" :error="errors['when']"></display-error>
							<label for="when">#When:</label>
							 <date-picker :option="options" name="when"  class="form-control" :date="date" :limit="limit" @change="changeDate"></date-picker>
						</li>
					</ul>
				</li>
				<li>
					<ul>
						<li>
							<display-error class="error" v-show="errors" :error="errors['what']"></display-error>
							<label class="what">#What:</label>
							<tag-input type="text" name="what"  class="form-control tag-input" :tags="_file.what" @change="changeWhat"></tag-input>
						</li>
						
						<li>
							<display-error class="error" v-show="errors" :error="errors['who']"></display-error>
							<label for="who">#Who: </label>
							<tag-input type="text" name="who"  class="form-control tag-input" :tags="_file.who" @change="changeWho"></tag-input>
						</li>
						
						<li>
							<display-error class="error" v-show="errors" :error="errors['why']"></display-error>
							<label for="why">#Why:</label>
							 <input type="text" name="why"  class="form-control" v-model="_file.why">
						</li>
					</ul>
				</li>
				
				

				
				
				
				
			</ul>
			<a class="btn btn-primary modal-button" @click.prevent="update(active.id)">Save changes</a>
			<a class="btn btn-secondary modal-button" @click.prevent="close">Cancel</a>
			<a href="#" class="close" @click.prevent="close">&#10005</a>
		</div>
	</div>
</div>
</template>

<script>
import moment from 'moment'
import datePicker from 'vue-datepicker'
import displayError from './../inputs/display-error'
export default {

	name: 'edit-modal',
	props:{
		active:{
			required:true,
			type:Object
		},
		url:{
			required:true,
			type:String
		},
		show:{
			required:true,
			type:Boolean
		}

	},
	components:{
		datePicker,
		displayError
	},
	data () {
		return {
			_file:{},
			errors:false,
			limit:[{
				type:'fromto',
				to:moment().format('YYYY-MM-DD')
			}],
			options:{
				placeholder:'#When',
				type: 'day',
        		week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
        		month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        		format: 'YYYY-MM-DD',
        		inputStyle: {
		          	display: 'block',
					width: '100%',
					height: 'auto',
					border:'none'
        		},
        		color:{
				    header: 'blue',
				    headerText: 'white'
				},
			}
		}
	},
	mounted(){
		this.date={time:this.active.when}
		this._file=JSON.parse(JSON.stringify(this.active))
	},
	computed:{
	},
	watch:{
		show(){
			scroll(0,0)
		},
	},
	methods:{
		close(){
			this.$emit('edit',false)
		},
		update(id){
	  		let f = new FormData();
	  		f.append('title',this._file.title)
	  		f.append('description',this._file.description)
	  		f.append('who',JSON.stringify(this._file.who))
	  		f.append('when',this._file.when)
	  		f.append('what',JSON.stringify(this._file.what))
	  		f.append('where',this._file.where)
	  		f.append('why',this._file.why)
	  		f.append('_method','patch')
	  		console.log(this._file)
	  		axios.post(window.location.protocol + "//" + window.location.host + this.url + '/' + id,f,{
	  				validateStatus:status => status < 422
	  			})
	  			.then(res => {
	  				console.log(res)
	  				this.$emit('edit',this._file)
	  			})
	  			.catch(res => this.errors = res.response.data)
	  	},
	  	changeDate(date){
	  		this.date={time:date}
  			this.active.when = moment(date).format('YYYY-MM-DD')
	  	},
	  	initPlace(event){
	  		console.log("initializing field",event.target)
			let placebox=new google.maps.places.Autocomplete(event.target)
			console.log(placebox)
			try{
				placebox.addListener('place_changed',() => {
					this.active.where = placebox.getPlace().formatted_address
				})	
			}
			catch(e){
				console.error(e)
			}	
		},
		changeWhat(tags){
			this._file.what=tags
		},
		changeWho(tags){
			this._file.who=tags
		}
	},
};
</script>

<style lang="scss">
.modal-background{
	transition: .4s ease-out;
	position:absolute;
	z-index:1000;
	background-color:rgba(0,0,0,0.5);
	width:100%;
	height:100%;
	top:0;
	left:0;
	overflow:hidden;


	.modal-wrapper.modal-content{
		width:60%;
		background-color:white;
		padding:3rem;
		position:absolute;
		left:50%;
		top: 40%;
  		transform: translate(-50%, -40%);
  		border-radius:0;


		.modal-button{
			width:40%;
			margin:.5rem;
			margin-left:30%;
		}

		&.file-edit{
			label{
				margin-bottom:.5rem;
			}
			.fields > li{
				width:50%;
				float:left;
				
				 & > ul > li{
					margin-bottom:.5rem;
					padding:.5rem;
	
				}

					.error{
						float:right;
					}
			}
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
