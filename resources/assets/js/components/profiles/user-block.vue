<template>
	<a :href="'/profile/' + user.slug">
		<div class="block-wrapper">
			<img class="profile-picture" :src="user.avatar" alt="">
			<div class="details">
				<h1>{{ user.first_name + " " + user.last_name }}</h1>
				<h2>{{ user.location }}</h2>
			</div>
		</div>
	</a>
</template>

<script>
export default {

	name: 'user-block',
	props:{
		user:{
			type:Object,
			required:true
		}
	},
	data () {
		return {

		}
	}
};
</script>

<style lang="scss" scoped>
a{
	color:#636b6f;
}
.block-wrapper{
	padding:1rem;
	.profile-picture{
		border-radius:50%;
		width:30%;
		float:left;
		display:block;
	}
	.details{
		padding-left:1rem;
		float:left;
		width:70%;
		h1{
			margin-top:2rem;
			color:blue;
			font-size:1.8rem;
			margin-bottom:.3rem;
		}
	}
}
</style>