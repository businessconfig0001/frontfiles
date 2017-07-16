const url = '/files'
function upload(data){
	console.log(data)
	//add data
	let form = formDataFactory(data.data)

	//add img
	form.append('file',data.file,data.name)

	//upload
	return new Promise((resolve,reject) =>
		axios.post(window.location.protocol + "//" + window.location.host + url,form)
		.then(resolve)
		.catch(reject)
	)
}

function formDataFactory(data){
	let form= new FormData()
	let keys = Object.keys(data)
	for(let i = 0 ; i < keys.length ; i++ ){
		console.log(keys[i])
		form.append(keys[i],data[keys[i]])
	}
	return form
}
export {
	upload	
}