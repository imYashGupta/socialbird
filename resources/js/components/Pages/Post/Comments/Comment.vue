<template>

<div class="media pb-3 " :ref="'c_'+comment.id"  :class="{'mb-3 bb1px':(index!=total-1)}">

	<div class="media-img-wrap d-flex mr-10">
		<div class="avatar avatar-sm	">
			<img v-if="comment.user.images!=null" :src="comment.user.images" alt="user" class="avatar-img rounded-circle">
			<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+comment.user.avatar">
				<span class="initial-wrap">
					<span>{{ comment.user.firstname.charAt(0)+comment.user.lastname.charAt(0) }}</span>
				</span>
			</span>
		</div>
	</div>
	<div class="media-body">
		<div class="text-capitalize font-14 font-weight-500 text-dark">{{ comment.user.fullname }}</div>
		<textarea v-if="editMode" v-model="commentText" class="form-control filled-input bg-transparent" rows="1" placeholder="Edit Comment"></textarea>
		<div class="font-15" v-else><p>{{ commentText }} {{ comment.id }}</p></div>
		<div class="d-flex mt-10">
			<span class="font-14 text-light mr-15">{{ comment.created_at }}</span>
			<template v-if="user.id!=comment.user.id" >
				<a href="#" class="font-14 text-light text-capitalize font-weight-500">reply</a>
				<span class="ml-2 mr-2">·</span>
			</template>
			<template v-if="user.id==comment.user.id">
				<a v-if="editMode" href="#" @click="updateComment()" class="font-14 text-primary text-capitalize font-weight-500">Save</a>
				<a  href="#" v-else @click="startEditMode()" class="font-14 text-light text-capitalize font-weight-500">Edit</a>
				<span class="ml-2 mr-2">·</span>
				<a href="#" @click="deleteComment(comment.id)" class="font-14 text-light text-capitalize font-weight-500" >Delete</a>
			</template>
		</div>
	</div>
</div>
</template>
<script type="text/javascript">
	import {helper} from './../../../../helper';
	import {eventBus} from './../../../../app';
	export default{
		props:['comment','index','total'],
		data(){
			return{
				editMode:false,
				commentText:this.comment.comment
			}
		},
		computed:{
			user(){
				return this.$store.state.currentUser;
			}
		},
		methods:{
			startEditMode(){
				this.editMode=true;
			},
			updateComment(){
				if (this.commentText!='') {
					helper.API.UpdateComment(this.commentText,this.comment.id)
					.then(res =>{
						//console.log(res)
						this.editMode=false;
					})
					.catch(er =>{
						console.log(er)
					})
				}
			},
			deleteComment(id){
				helper.API.DeleteComment(id)
				.then(res => {
					swal("Comment Deleted!", {
                        icon: "success",
                    });
					eventBus.$emit('PostCommentDeleted',this.index); 
				})
				.catch(er =>{
					helper.Notice.Error();
				})
			}
		},
		created(){
			 
		}
	}
</script>