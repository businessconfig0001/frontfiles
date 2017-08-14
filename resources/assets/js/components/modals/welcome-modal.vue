<template>
<div class="welcome-wrapper">
	<div v-if="lang === 'es'">
		
	</div>
	<div v-else-if="lang ==='pt'">
		
	</div>
	<div v-else>
		<h1>You are now an official FrontFiler!</h1>
		<h2>we are ready to start receiving your editorial footage, images or illustrations.</h2> 
		<p>
			You can complete your profile information whenever you want. After you upload your files, they will be available for sale and for sharing (the compressed copy).During this Beta phase, files can be sold by us directly to the client, and only if they show urgent relevancy. However, you decide whether you wish to sell or not, as well as set the price for all of your files.In the next platform’s phase you will have full control over the sales , which will be automatic and direct from you to the buyer'
		</p>
	</div>
	<div class="controls">
		<ul>
			<li><a @click.prevent="lang ='en'">EN</a></li>
			<li><a @click.prevent="lang ='es'">ES</a></li>
			<li><a @click.prevent="lang ='pt'">PT</a></li>
		</ul>
	</div>
</div>
</template>

<script>
export default {

	name: 'welcome-modal',

	data () {
		return {
			lang:'en'
		}
	}
}
</script>

<style lang="scss" scoped>
.welcome-wrapper{
	.controls{
		float:right;
		margin-top:1.5rem;

		li{
			display:inline-block;
			padding:.5rem;
		}
		li + li {
			border-left: 1px solid blue;
		}

	}
}
</style>