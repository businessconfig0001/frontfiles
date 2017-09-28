<template>
<div class="container">
    <div class="show-container">
		<div class="file-wrapper">
			<div class="file col-md-12">
				<div class="col-md-8">
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
					<span class="date">Uploaded on {{date_string}}</span>	
				</div>

				
				<div class="file-info col-md-4">
					<div class="info">
						<h2>{{file.title}}</h2>
						
						<p>{{file.description}}</p>
						
						<ul class="tags">
							<li>#Author <span>{{author}}</span></li>
							<li v-show="file.where">#Where<span>{{file.where}}</span></li>
							<li v-show="file.when">#When<span>{{file.when}}</span></li>
							<li v-show="file.what">#What #Why #How
								<span>
									<ul class="tag-list">
										<li v-for="tag in file.what">{{tag}}</li>
									</ul>
								</span>
							</li>
						</ul>
						<div class="extra-info">
							<ul>
								<li>{{file.short_id}}</li>
								<li>{{file.type}}</li>
								<li>{{ size }}</li>
							</ul>
						</div>
						<a v-if="current" class="btn btn-secondary" @click.prevent="showEdit = true">Edit</a>
						<a v-if="current" class="btn btn-primary" @click.prevent="showDelete = true">Remove</a>
					</div>
				
				</div>
				
			</div>
		</div>
	</div>
	<edit-modal v-if="current" :show="showEdit" :active="file" @edit="handleEdit" :url="'/files'"></edit-modal>
	<delete-modal v-if="current" :show="showDelete" :id="file.id" @close="showDelete=false" @remove="del"></delete-modal>
</div>
</template>

<script>
import editModal from './../modals/edit-modal'
import deleteModal from './../modals/delete-modal'
import moment from 'moment'
export default {

	name: 'file-detail',
	components:{
		editModal,
		deleteModal
	},
	props:{
		fileprop:{
			required:true,
			type:Object
		},
		user:{
			required:false,
			type:Object,
			default:() => {id:''}
		},
		author:{
			required:true,
			type:String
		}
	},
	data () {
		return {
			file:JSON.parse(JSON.stringify(this.fileprop)),
			showDelete:false,
			showEdit:false,
		}
	},
	computed:{
		date_string(){
			return moment(this.file.created_at).format('MMMM Do YYYY, h:mm:ss a')
		},
		current(){

			if(this.user)return this.file.user_id === this.user.id
			else return false
		},
		size(){
			return Math.round((this.file.size/Math.pow(10,6) * 100))/100 + 'MB'
		}
	},
	methods:{
		handleEdit(file){
			if(file)this.file=file
			this.showEdit=false
	  	},
	  	del(){
	  		location.replace(location.origin + '/profile/' + this.user.slug)
	  	},
	}
};
</script>

<style lang="scss" scoped>
.container{
	width:auto;
	margin-top:2rem;
}
.file-wrapper{
	.date{
		color:#bbb;
		float:left;
		width:100%;
		padding-top:.5rem;
		margin-bottom:2rem;
	}
	.file{

		.file-container{
			display:flex;
			justify-content:left;
			align-items:left;

			video,audio{
				width:100%;
				
			}
		}

		.img{
			width:100%;
			position: relative;

			img{
				width:100%;
			}

			a{
				position: absolute;
				bottom: 0;
				right: 0;
				z-index: 100;
				font-size: 2rem;
				margin: 1rem;
				color:#eee
			}
		}
	}

	.file-info{
		display:block;
		
		h2{
			font-size:2rem;
			margin-bottom:1rem;
			text-transform: uppercase;
			overflow:hidden;
		}

		p{
			padding-bottom:.5rem;
			border-bottom:1px solid black;
		}

		li{
			font-weight:400;
			color: #636b6f;
			padding:.4rem;
			padding-left:0;
			margin-left:0;
			

			span{
				color:blue;
				padding:.2rem;
			}

		}
		.info{
			.btn{
				width:47%;
				margin:1%;
			}

			.tags{
				margin-top:1rem;

				.tag-list{
					display:inline;
					li{
						display:inline-block;
						color:blue;
						padding:0 .2rem;
					}
				}
			}
			.extra-info{
				li{
					display:inline-block;
					color:#ddd;
				}
			}
		}
	}
}
</style>