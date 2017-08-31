<template>
<div class="display-container">
	<ul class="video-list">
		<li v-for="file in files">
			<file-block :file="file"></file-block>
		</li>
	</ul>
</div>
</template>

<script>
import fileBlock from './file-block'
export default {

	name: 'files-display',
	components:{
		fileBlock
	},
	props:{
		files:{
			required:true,
			type:Array
		}
	},
	data () {
		return {

		}
	}
};
</script>

<style lang="scss" scoped>
.display-container{
	width:100%;
  		li{
			width:33%;
			padding:.5rem;
			float:left;
		}
	
}
	
</style>