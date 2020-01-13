<template>
<div class="card-footer">
	<div class="media w-100 align-items-center">
		<div class="media-img-wrap d-flex mr-15">
			<div class="avatar avatar-sm">
				<img  v-if="user.images!=null" :src="user.images" alt="user" class="avatar-img rounded-circle">
				<span v-else class="avatar-text rounded-circle" :class="' avatar-text-'+user.avatar" >
					<span class="initial-wrap">
						<span>{{ user.firstname.charAt(0)+user.lastname.charAt(0) }}</span>
					</span>
				</span>
			</div>
		</div>
		<div class="media-body">
			<textarea @keydown.enter.prevent="Create" v-model="comment" class="form-control filled-input bg-transparent" rows="1" placeholder="Leave a comment..."></textarea>
		</div>
	</div>
</div>
</template>
<script>
	import { eventBus } from '../../../app'; 

	export default{
		props:["post","index"],
		data(){
			return{
				comment:''
			}
		},
		computed:{
			user(){
				return this.$store.getters.user.user;
			}
		},
		methods:{
			Create(){
				if (this.comment.length > 0) {
					axios.post('/api/comment.compose',{comment:this.comment,post_id:this.post.id})
					.then(response => {
						eventBus.$emit('commentCreated',{index:this.index,comment:response.data.comment});
						this.comment='';
					})
					.catch(error => {
						console.log(error);
					})

				}
			}
		},
		created(){
		//	console.log(this.index);
		}
	}
</script>