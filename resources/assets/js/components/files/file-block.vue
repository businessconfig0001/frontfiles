<template>
<div class="block-container">
		<div class="file-wrapper">
			<div class="file-container" v-if="file.processed">
			<video controls v-if="file.type === 'video'">
				<source :src="file.azure_url">
			</video>
			<div class="img" v-else-if="file.type === 'image'">
				<img  :src="file.azure_url" alt="">	
				<a :href="file.azure_url">
					<i class="fa fa-download"></i>
				</a>
			</div>
			
			<audio controls v-else-if="file.type === 'audio'">
				<source :src="file.azure_url">
			</audio>
			<div v-else class="download-file">
				<a :href="file.azure_url">
					<i class="fa fa-download"></i>
				</a>
			</div>
		</div>
		<div class="file-container" v-else>
			<img src="/images/processing.png" alt="">
		</div>	
		<div class="file-info">
			<h2><a :href="file.path">{{ file.title }}</a></h2>
			<p class="location">@{{file.where}} on {{date}}</p>
		</div>
		<div class="buttons" v-if="active">
			<a  @click.prevent="showEdit = true"><img src="/images/edit-btn.png" alt=""></a>
			<a  @click.prevent="showDelete = true"><img src="/images/close-icon.svg" alt=""></a>
		</div>
	</div>
	
	<edit-modal :show="showEdit" :active="file" @edit="handleEdit" :url="'/files'"></edit-modal>
	<delete-modal :show="showDelete" :id="file.id" @close="showDelete=false" @remove="del"></delete-modal>
</div>
</template>

<script>
import editModal from './../modals/edit-modal'
import deleteModal from './../modals/delete-modal'
import displayError from './../inputs/display-error'
import moment from 'moment'
import datePicker from 'vue-datepicker'
export default {

	name: 'file-block',
	components:{
		displayError,
		datePicker,
		deleteModal,
		editModal
	},
	props:{
		file:{
			required:true,
			type:Object
		},
		active:{
			required:true,
			type:Boolean
		}
	},
	mounted(){
		this.file.errors={}
	},
	computed:{
		date(){
			return moment(this.file.when).format('MMMM Do YYYY')
		},
		formatted_date(){
			this.date.format('DD/MM/YYYY')
		},
		short_desc(){
			if(this.file.description.length > 100) return this.file.description.substring(0,100) + ' ...'
			return this.file.description
		}
	
	},
	data () {
		return {
			status:true,
			url:'/files',
			showDelete:false,
			showEdit:false,
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
		    		color: {
					    header: 'blue',
					    headerText: 'white'
					  }

			}
    };
  },
  methods:{
  	handleEdit(file){
  		this.showEdit= false
  		if(file){
  			this.$emit('edit',file)
  		}
  	},
  	del(){
  		this.showDelete=false;
  		this.$emit('remove',this.file.id)
  	},
  	changeDate(date){
  		this.file.when = moment(date).format('YYYY-MM-DD')
  	},
  	initPlace(event){
		let placebox=new google.maps.places.Autocomplete(event.target)
		try{
			placebox.addListener('place_changed',() => {
				this.file.where = placebox.getPlace().formatted_address
			})	
		}
		catch(e){}	
	}
  }
};
</script>

<style lang="scss" scoped>
.block-container{
	width:100%;
	background-color:rgb(255,255,255);
	padding: 1rem;
	.file-wrapper{
		position:relative;

		&:hover{
			.buttons{
				
				visibility:visible;
			}
		}

		.buttons{
			margin-top:1rem;
			visibility: hidden;
			position:absolute;
			bottom:110px;
			right:5px;
			z-index:100;
			width:20%;
			transition: .4s ease-in-out;
			a{
				float:left;
				width:40%;
				margin-right:.3rem;
				cursor:pointer;

				img{
					width:20px;
					height:20px;
					
				}
			}
				
		}	
	}
	

	.file-container{
		display:flex;
		justify-content:center;
		align-items:center;
		height:13em;
		overflow:hidden;

		h2{
			text-align:left;
			color:#ddd;
		}
	}
	video,img{
		height:100%;
	}
	audio,.download-file{
		width:100%;

	}
	.img{
		position: relative;

			a{
				position: absolute;
				bottom: 0;
				right: 0;
				z-index: 100;
				font-size: 1rem;
				margin: .5rem;
				color:#eee
			}
	}

	.file-info{
		padding:.5rem;


		h2{
			padding: .5rem 0;
			height:50px;
			font-weight:bolder;
			text-align:left;
			a{
				color:blue;
			}
		}

		.location{
			color:#ccc;
		}

		li{
			font-weight:bolder;
			margin-bottom:.5rem;
			span{
				padding-left:.5rem;
				font-weight:400;
			}
		}
		
	}

	.file-edit{
		input,textarea,.tag-input{
			width:100%;
			margin-bottom:1rem;
		}
	}

	.btn{
		width:100%;
		margin: 0.5rem auto;
	}
}
</style>