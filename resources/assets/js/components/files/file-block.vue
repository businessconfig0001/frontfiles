<template>
<div class="block-container">
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
		<h2>Your file is still being processed</h2>
	</div>	
	<div class="file-info">
		<h2><a :href="file.path">{{ file.title }}</a></h2>
		</ul>
		<a class="btn btn-secondary" @click.prevent="showEditModal">edit</a>
		<a class="btn btn-secondary" @click.prevent="showDelete = true">delete</a>
	</div>
	<delete-modal :show="showDelete" :id="file.id" @close="showDelete=false" @remove="del"></delete-modal>
</div>
</template>

<script>
import deleteModal from './../modals/delete-modal'
import displayError from './../inputs/display-error'
import moment from 'moment'
import datePicker from 'vue-datepicker'
export default {

	name: 'file-block',
	components:{
		displayError,
		datePicker,
		deleteModal
	},
	props:{
		file:{
			required:true,
			type:Object
		}
	},
	mounted(){
		this.file.errors={}
	},
	computed:{
		date(){
			return moment(this.file.when)
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
  	showEditModal(){
  		this.$store.commit('editModal',this.file.title)
  	},
  	del(){
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

	.file-container{
		display:flex;
		justify-content:center;
		align-items:center;
		height:13em;
		overflow:hidden;

		h2{
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
			text-align:center;
			a{
				color:blue;
			}
		}

		p{
			margin:.5rem 0;
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