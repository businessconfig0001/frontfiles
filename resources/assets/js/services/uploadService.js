const url = '/files'
function upload(data,store){
	//add data
	let form = formDataFactory(data.data)
	//add img
	form.append('file',data.file,data.name)

	//upload
	let previous=0
	return axios.post(window.location.protocol + "//" + window.location.host + url,form,{
		onUploadProgress:function(e){
			console.log(e.loaded)
			store.commit('addProgress',e.loaded- store.state.previousProgress)
			previous=e.loaded
		},
		validateStatus:status => status < 422
	})
		
}

function formDataFactory(data){
	let form= new FormData()
	let keys = Object.keys(data)
	for(let i = 0 ; i < keys.length ; i++ ){
		console.log('prossesing',keys[i])
		if(data[keys[i]] instanceof Array){
				form.append(keys[i],JSON.stringify(data[keys[i]]))
		}
		else form.append(keys[i],data[keys[i]])
	}
	return form
}
export {
	upload	
}