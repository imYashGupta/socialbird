<template>
<div class="modal fade" id="commentEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Comment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<textarea v-model="comment" class="form-control filled-input bg-transparent p-0" rows="3" placeholder="Edit Comment..."></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" @click="commentUpdate" >Save changes</button>
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
			comment:'',
			commentData:null,
			index:null
		}
	},
	created(){
		eventBus.$on('commentEdit',(data) => {
			this.comment=data.comment.comment;
			this.commentData=data.comment;
			this.index=data.index;
		})
	},
	methods:{
		commentUpdate(){
			axios.post('/api/comment.edit',{id:this.commentData.id,comment:this.comment})
			.then(res => {
				eventBus.$emit('commentUpdated',{comment:this.comment,index:this.index});
			})
			.catch(err => {
				console.log(err);
			})
		}
	}
}
</script>