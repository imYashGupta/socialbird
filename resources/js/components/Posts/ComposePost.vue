<template>
<div class="card shadow-sm shadow-hover-lg">
	<div class="card-body">
		<textarea v-model="postBody" class="form-control filled-input bg-transparent p-0" rows="1" placeholder="Write a Post..."></textarea>
		<template v-if="uploading">
			<div class="progress mt-3">
				<div class="progress-bar  progress-bar-striped bg-primary progress-bar-animated " :style="{width:progress+'%'}" role="progressbar"  aria-valuemin="0" aria-valuemax="100"></div>
			</div>
			<span class="">{{file.name}} ({{progress}}%)</span>
		</template>
		<input type="file" ref="image" class="d-none" @change="ImageChange">
		<button   ref="createBtn" @click="startUpload" class="btn btn-primary float-right mt-3">{{btnText}} <span v-if="StartProcess" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span></button>
		<button   ref="imgBtn" class="btn btn-light float-right mr-1 mt-3" @click.prevent="OpenDialog"><i class="fas fa-image"></i></button>
	</div>
</div>
</template>
<script>
	export default{
		data(){
			return{
				postBody:'',
				ImageName:'',
				file: '',
			    progress: 0,
			    uploading:  false,
			    StartProcess:false,
			    btnText:'Create Post',
			}
		},
		methods:{
		    startUpload(){
		    	this.startProcess(); 
		    	if (this.file!='' || this.postBody!='') {	
			    	let formData = new FormData();
			    	if (this.file!='') {
	        			formData.append('image', this.file);
			    	}
			    	if (this.postBody!='') {
	        			formData.append('text', this.postBody);
			    	}
					axios.post("/api/post.compose.v2",formData, {
						onUploadProgress: (progressEvent) => {
	                   		const totalLength = progressEvent.lengthComputable ? progressEvent.total : progressEvent.target.getResponseHeader('content-length') || progressEvent.target.getResponseHeader('x-decompressed-content-length');
							if (totalLength !== null) {
								this.progress = Math.round( (progressEvent.loaded * 100) / totalLength );
							}
	           			},
					})
					.then((response) => {

						this.$store.commit('addPostToFeed',response.data.post); 
		    			this.stopProcess();
		    			//console.log(response)
					})
					.catch((er) => {
						this.$store.dispatch('Toast',{
							heading:'Error!!',
							html:"Something got wrong while Creating Post!",
							type:'jq-toast-danger'
						});
						//Object.values(er.data)
						this.stopProcess(); 
					});
		    	}
		    	else{
		    		this.$store.dispatch('Toast',{
						heading:'Oh Snap! Error..',
						html:"Text field is mandatory to create a post,Image is Optional",
						type:'jq-toast-warning'
					});
					this.stopProcess(); 
		    	}
		    },
			ImageChange(e){
				if (e.target.files[0]!=null) {
                	this.uploading=true;
                	this.file=e.target.files[0];
				}
				else{
					this.file='';
					this.uploading=false;
					this.progress=0;
				}
            },
			OpenDialog(){
				$(this.$refs["image"]).click();
			},
			startProcess(){
				this.StartProcess=true;
		    	$(this.$refs["createBtn"]).attr('disabled','');
		    	$(this.$refs["imgBtn"]).attr('disabled','');
			},
			stopProcess(){
				$(this.$refs["createBtn"]).removeAttr('disabled');
				$(this.$refs["imgBtn"]).removeAttr('disabled');
    			this.StartProcess=false;
    			this.file='';
    			this.ImageName='';
    			this.uploading=false;
    			this.postBody='';
    			this.progress=0;
			},
		}
	}
</script>