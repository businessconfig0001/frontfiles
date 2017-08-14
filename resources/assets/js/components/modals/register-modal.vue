<template>
<div>
	<modal-container>
		<div slot="pt">
		  
		</div>
		<div slot="br">
		  
		</div>
		<div slot="es">
		  
		</div>
		<div slot="en">
        	<h1>Dear friend: <br />Welcome to FrontFiles</h1>
			<p>
				 Thank you for joining us on this Beta version and Platform testing. Please note that this is a community work-in-progress area. We are very pleased that you are helping us to improve its quality. 
			</p>
			<h2>FrontFiles is a global web-based community of free reporters and journalists.</h2>
			<p>
				 By becoming a FrontFiler you will be part of a worldwide group of people committed to building a new model for news and information sourcing, produced by the users and based on true images, footage and reports and effective fact checking. By collaborating - sharing information, technology, equipment, lodging, transportation and more 
			 </p>
			 <h2>We empower ourselves and make our jobs easier.</h2>
			 <p>
				 By selling our files in a way that’s fast, easy and free of bureaucracy, we find financial empowerment. This is the beginning of a long and powerful journey. Let’s do it together.
			 </p>
        </div>		
	</modal-container>
</div>
</template>

<script>
export default {

	name: 'register-modal',
	data () {
		return {

		};
	},
	mounted(){
		let modalName = 'register'
		if(!localStorage.getItem(modalName))this.$store.commit('openModal',modalName)
	}
};
</script>

<style lang="css" scoped>
</style>