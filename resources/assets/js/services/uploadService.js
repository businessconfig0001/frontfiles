const url = '/files'
function upload(data,progress){
	//add data
	let form = formDataFactory(data.data)
	//add img
	form.append('file',data.file,data.name)

	//upload
	return new Promise((resolve,reject) =>
		axios.post(window.location.protocol + "//" + window.location.host + url,form,{
			onUploadProgress:progress
		})
		.then(resolve)
		.catch(err=>{
			data.errors=err.response.data
			reject(data)
		})
	)
}

function formDataFactory(data){
	let form= new FormData()
	let keys = Object.keys(data)
	for(let i = 0 ; i < keys.length ; i++ ){
		console.log('prossesing',keys[i])
		if(keys[i] === 'what' ||keys[i] === 'who'){
				form.append(keys[i],JSON.stringify(data[keys[i]]))
		}
		else form.append(keys[i],data[keys[i]])
	}
	return form
}
export {
	upload	
}