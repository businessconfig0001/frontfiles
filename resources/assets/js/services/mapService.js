const url="./world.geojson"
const d3 = require('d3')
let projection

function drawMap(el){
	return new  Promise((resolve) => {
		let width=parseInt(el.style("width"))
		let height=parseInt(el.style("height"))
		projection=d3.geoMercator()
	      //.scale(width / 2 / Math.PI)
	      .translate([width / 2 , height/2  + 210])
		let path=d3.geoPath().projection(projection)

	    d3.json(url, (err, geojson) => {
	      el.append("path")
	      	.attr("d", path(geojson))
	      	.attr("fill","blue")
	      	resolve()
	     })
	})
	
}

function createMarkers(data){
	
	let coors=data.map(d => {
		return {
			lat:d.latitude,
			lng:d.longitude
		}
	})
	console.log(coors)
	let markers =[]
	for(let i = 0; i < coors.length ; i++){
		let c=coors[i]
		let contains=false;
		for(let j = 0; j < markers.length ; j++){
			let m=markers[j]
			console.log(m.lat,c.lat,m.lng,c.lng)
			if(m.lat === c.lat && m.lng === c.lng){
				contains=true
				m.count++;	
			} 
		}
		if(!contains)markers.push({
			lat:c.lat,
			lng:c.lng,
			count:1
		})
	}
	return markers

}
function drawMarkers(markers,el){
	let pins =el.selectAll(".mark")
		    .data(markers)
		    .enter()

	pins.append("circle")
		    .attr('fill','black')
		    .attr('r', 10)
		    .attr("transform", d => "translate(" + projection([d.lng,d.lat]) + ")")

    pins.append('text')
    	.attr("transform", d => "translate(" + projection([d.lng,d.lat]) + ")")
    	.attr('dx',d => -4)
    	.attr('dy',d => 4)
	    .style('fill','white')		     	    
	    .style('font-size','12px')
	    .text(d => d.count)

}

function map(el,data){
	el=d3.select(el)
	drawMap(el).then(() => {
		drawMarkers(createMarkers(data),el)	
	})
	
}

export {
	map
}