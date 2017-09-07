<template>
<div class="file-overview">
	<a @click.prevent="show =true" class="overview-wrapper">
		<h2>{{file.name}}</h2>
	</a>
	<file-modal :upload="file" :show="show" @close="show = false"></file-modal>
</div>
</template>

<script>
import fileModal from './../modals/file-modal'
export default {

	name: 'file-overview',
	components:{
		fileModal
	},
	props:{
		file:{
			type:Object,
			required:true,
		}
	},
	data () {
		return {
			show:false
		}
	}
};
</script>

<style lang="scss" scoped>
</style>