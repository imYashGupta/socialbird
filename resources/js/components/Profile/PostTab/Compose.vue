<template>
<div class="card shadow-sm shadow-hover-lg">
	<div class="card-body">
		<textarea v-model="postBody" class="form-control filled-input bg-transparent p-0" rows="1" placeholder="Write a Post..."></textarea>
		<button @click="ComposePost" class="btn btn-primary float-right mt-3">Create Post</button>
	</div>
</div>
</template>
<script>
	export default{
		data(){
			return{
				postBody:''
			}
		},
		methods:{
			ComposePost(){
				//this.$store.dispatch('ComposePost',this.postBody)
				// .then(res => {
				// 	this.postBody='';
				// })
			}
		}
	}
</script>