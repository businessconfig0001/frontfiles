<template>
	<div class="map-wrapper">
		<svg ref="map"></svg>
	</div>
</template>

<script>
const d3 = require('d3')
export default {

	name: 'map-component',

	data () {
		return {
			svg:{}
		}
	},
	props:{
		data:{
			required:true,
			type:Array
		}
	},
	mounted(){
		this.svg=d3.select(this.$refs.map)
		let width=parseInt(this.svg.style("width"))
		let height=parseInt(this.svg.style("height"))
		console.log(this.svg,width,height)
		let projection=d3.geoMercator()
	      //.scale(width / 2 / Math.PI)
	      .translate([width / 2 - 30, height/2  + 210])
		let path=d3.geoPath().projection(projection)

		let url = "http://enjalot.github.io/wwsd/data/world/world-110m.geojson"
	    d3.json(url, (err, geojson) => {
	      this.svg.append("path")
	      	.attr("d", path(geojson))
	      	.attr("fill","blue")
	      this.svg.selectAll(".mark")
		    .data(this.data)
		    .enter()
		    .append("image")
		    .attr('class','mark')
		    .attr('width', 20)
		    .attr('height', 20)
		    .attr("xlink:href",'https://cdn3.iconfinder.com/data/icons/softwaredemo/PNG/24x24/DrawingPin1_Blue.png')
		    .attr("transform", d => "translate(" + projection([d.longitude,d.latitude]) + ")")
	    })

	}
};
</script>

<style lang="scss" scoped>
	.map-wrapper{
		width:100%;
		height:53rem;

		svg{
			margin-top:-8rem;
			width:100%;
			height:100%;
		}
	}
</style>