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
				</div>

				
				<div class="file-info col-md-4">
					<div class="info">
						<h2>{{file.title}}</h2>
						<span class="date">Uploaded on {{date_string}}</span>
						<p class="col-md-12">{{file.description}}</p>
						
						<ul class="col-md-12 tags">
							<li v-show="file.where"><span>{{file.where}}</span></li>
							<li v-show="file.when"><span>{{file.when}}</span></li>
							<li v-show="file.who"><span>{{file.who}}</span></li>
							<li v-show="file.what"><span>{{file.what}}</span></li>
							<li v-show="file.why"><span>{{file.why}}</span></li>
						</ul>	
					</div>
				
				</div>
			</div>
		</div>
	</div>
</div>
</template>

<script>
import moment from 'moment'
export default {

	name: 'file-detail',
	props:{
		file:{
			required:true,
			type:Object
		}
	},
	data () {
		return {

		}
	},
	computed:{
		date_string(){
			return moment(this.file.created_at).format('MMMM Do YYYY, h:mm:ss a')
		}
	}
};
</script>

<style lang="scss" scoped>
.container{
	width:auto;
}
.file-wrapper{
	.file{

		.file-container{
			display:flex;
			justify-content:center;
			align-items:center;
			min-height:80vh;

			video,audio{
				width:auto;
				
			}
		}

		.img{
			position: relative;

			img{
				width:auto;
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
			border-bottom:1px solid black;
			margin-bottom:1rem;
		}
		li{
			font-weight:400;
			color: #636b6f;
			padding:.4rem;
			

			span{
				color:blue;
				font-weight:bolder;
			}
		}
		.info{
			.date{
				color:#ccc;
				float:left;
				width:100%;
				margin-bottom:2rem;
				margin-left:.5rem;
			}

			.tags{
				margin-top:1rem;
			}
		}
	}
}
</style>