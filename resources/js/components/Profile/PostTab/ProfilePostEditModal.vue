<template>
<div class="modal fade" id="p-postEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Post</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<textarea v-model="modalBody"  class="form-control filled-input bg-transparent p-0" rows="3" placeholder="Edit Post..."></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" @click="updatePost()">Save changes</button>
			</div>
		</div>
	</div>
</div>
</template>
<script>
	import { eventBus } from '../../../app'; 

	 export default{
	 	data(){
	 		return{
				editModal:null,
				modalBody:''		
	 		}
	 	},
	 	props:['modal'],
	 	methods:{
	 		updatePost(){
	 			axios.post('/api/post.update',{body:this.modalBody,id:this.editModal.post.id})
	 			.then(res => {
	 				eventBus.$emit('postUpdated',{body:this.modalBody,index:this.editModal.index});
	 				$("#p-postEditModal").modal('hide');
	 			})
	 		}
	 	},
	 	created(){
	 		this.editModal=this.modal;
	 		this.modalBody=this.modal.post.body;
	 	}	
	 }
</script>