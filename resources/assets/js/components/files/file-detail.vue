<template>
<div class="file-wrapper">
	<div class="file col-md-8">
		<div class="file-container" v-if="file.processed">
			<video controls v-if="file.type === 'video'">
				<source :src="file.azure_url">
			</video>
			<div v-else-if="file.type === 'image'">
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
	</div>
	<div class="file-info col-md-4">
		<h2><a :href="file.path">{{ file.title }}</a></h2>
		<p>file.description</p>
		<ul>
			<li v-show="file.where">#Where: <span>{{file.where}}</span></li>
			<li v-show="file.when">#When: <span>{{file.when}}</span></li>
			<li v-show="file.who">#Who: <span>{{file.who}}</span></li>
			<li v-show="file.what">#What: <span>{{file.what}}</span></li>
			<li v-show="file.why">#Why: <span>{{file.why}}</span></li>
		</ul>
	</div>
</div>
</template>

<script>
export default {

	name: 'file-detail',

	data () {
		return {

		}
	}
};
</script>

<style lang="scss" scoped>
</style>