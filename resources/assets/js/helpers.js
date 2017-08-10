/**
 * 
 * @param { Array } arr- the array were you want to remove the duplicates
 * @returns  Array } array - array without duplicates
*/

function unique(arr){
	let newArray=[]
	if(arr.length){
		let keys =Object.keys(arr[0])
	
		arr.forEach(v => {
			let contains=false
			newArray.forEach(record => {
				if(equals.apply(record,[v])) contains = true
			})
			if(!contains)newArray.push(v)
		})
	}
	
	return newArray
}

/**
 * @param { Object } obj - the object we want to compare against
*/
function equals(obj){
	try{
		let keys =Object.keys(this)
		let match=false
		keys.forEach(key => {
			if(this[key] instanceof Object){
				match=true
			}
			else if(this[key] === obj[key]){
				match=true
			}
			else match =false
		})
		if(match)return true
		return false
	}
	catch(e){
		return false
	}
}

function getQuery(query){
	let url=window.location.href
    query = query.replace(/[\[\]]/g, "\\$&")
    let regex = new RegExp("[?&]" + query + "(=([^&#]*)|&|#|$)")
    let results = regex.exec(url)
    if (!results) return null
    if (!results[2]) return ''
    return decodeURIComponent(results[2].replace(/\+/g, " "))
}

export{
	unique,
	equals,
	getQuery
}