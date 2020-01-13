<template>
<div >
	<div class="media pb-3 mb-3 bb1px" >
		<div class="media-img-wrap d-flex mr-10" >
            <avatar :avatar="{size:'sm',firstname:comment.user.firstname,lastname:comment.user.lastname,color:comment.user.avatar,image:comment.user.images}"></avatar> 
		</div>
		<div class="media-body" >
			<div class="text-capitalize font-14 font-weight-500 text-dark" > {{comment.user.fullname}} </div>
			<div class="font-15" >
				<p v-if="!editMode">{{comment.comment}}</p>
				<textarea onfocus="" v-else v-model="comment.comment" class="form-control filled-input bg-transparent" placeholder="edit your comment..." rows="1">
                 </textarea>		
			</div>
			<div class="d-flex mt-10" >
				<span class="font-14 text-light" >{{comment.created_at}}</span>
				<template v-if="currentUser.username==comment.user.username">
					<span class="ml-2 mr-2" > · </span>
					<a class="font-14 text-light text-capitalize font-weight-500" href="#" @click.prevent="update" v-if="editMode"> Save </a>
					<a class="font-14 text-light text-capitalize font-weight-500" href="#" @click.prevent="edit" v-else> Edit </a>
					<span class="ml-2 mr-2" > · </span>
					<a class="font-14 text-light text-capitalize font-weight-500" href="#" @click.prevent="remove"> Delete </a>
				</template>
			</div>
		</div>
	</div>
</div>
</template>
<script >
	import avatar from './../../../Elements/Avatar.vue';
	import {helper} from  './../../../../helper';
	import {eventBus} from  './../../../../app';

	export default{
		components:{
			avatar
		},
		data(){
			return {
				editMode:false,

			}
		},
		computed:{
		    currentUser(){
            	return this.$store.getters.user.user;
         	}
     	},
		props:['comment','index'],
     	methods:{
     		edit(){
     			this.editMode=true;
     		},
     		update(){
     			helper.API.UpdateComment(this.comment.comment,this.comment.id)
     			.then(res => {
     			})
     			.catch(er => {
     				helper.Notice.Error();
     			})
     			this.editMode=false;
     		},
			remove(){
				helper.API.DeleteComment(this.comment.id)
				.then(_=>{
			    	eventBus.$emit('CommentDeleted',this.index);
				})
			}
     	},
		created(){

		}
	}
</script>