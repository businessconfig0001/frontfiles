<template>
	<div v-show="show" class="modal-background clearfix">
		<div class="modal-wrapper modal-content col-md-4">
			<div class="modal-text">
				<div v-if="lang === 'es'">
					<slot name="es"></slot>
				</div>
				<div v-else-if="lang ==='pt'">
					<slot name="pt"></slot>
				</div>
				<div v-else-if="lang ==='br'">
					<slot name="br"></slot>
				</div>
				<div v-else>
					<slot name="en"></slot>
				</div>
				<div class="controls">
					<ul>
						<li :class="lang === 'en' ? 'active' : ''"><a @click.prevent="lang ='en'">EN</a></li>
						<li :class="lang === 'es' ? 'active' : ''"><a @click.prevent="lang ='es'">ES</a></li>
						<li :class="lang === 'br' ? 'active' : ''"><a @click.prevent="lang ='br'">PT</a></li>
					</ul>
				</div>
			</div>
			<a @click.prevent="close(true)" class="btn btn-primary modal-button">Ok</a>
	  		<a href="#" class="close" @click.prevent="close">&#10005</a>
		</div>
	</div>
</template>

<script>
export default {

	name: 'modal-container',
	data () {
		return {
			lang:'br'
		}
	},
	computed:{
		show(){
			scroll(0,0)
			return this.$store.state.showModal
		},
		modelData(){
			return this.$store.state.modalData
		}

	},
	methods:{
		close(confirm = false){
			this.$emit('close')
			if(confirm)localStorage.setItem(this.modelData,true)
			this.$store.commit('closeModal')
		}
	},
};
</script>

<style lang="scss">
.modal-background{
	transition: .4s ease-out;
	position:absolute;
	z-index:999999;
	background-color:rgba(0,0,0,0.5);
	width:100%;
	height:100%;
	top:0;
	left:0;
	overflow:hidden;


	.modal-wrapper.modal-content{
		background-color:white;
		padding:3rem;
		position:absolute;
		left:50%;
		top: 40%;
  		transform: translate(-50%, -40%);
  		border-radius:0;

  		h1,h2{
  			color:blue;
  			padding:1rem 0;
  		}
  		h1{
  			padding:2rem 0;
  			font-size: 1.6rem;
  		}

		.modal-button{
			width:60%;
			margin:2rem;
			margin-left:20%;
		}		
		.close{

			padding:1rem;
			position:absolute;
			top:0;
			right:0;
		}

		.controls{
			float:right;
			margin-top:1rem;

			li{
				display:inline-block;
				padding:.5rem;

				& + li {
					border-left:1px solid blue;
				}
			}
		}
	}
}

</style>
