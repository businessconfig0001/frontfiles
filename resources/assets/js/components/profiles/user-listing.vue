<template>
<div class="listing-wrapper">
	<ul>
		<li v-for="user in users">
			<user-block :user="user"></user-block>
		</li>
	</ul>
</div>
</template>

<script>
import userBlock from './user-block'
export default {

  	name: 'user-listing',
  	components:{
  		userBlock
  	},
	data () {
		return {

		}
	},
	props:{
		users:{
			type:Array,
			required:true
		}
	}

};
</script>

<style lang="scss" scoped>
.listing-wrapper{
	li{
		width:33%;
		float:left;
	}
}
</style>