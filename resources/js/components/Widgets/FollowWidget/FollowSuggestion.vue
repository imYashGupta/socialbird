<template>
<div v-if="users.length > 0" class="card card-refresh card-profile-feed shadow-sm shadow-hover-lg">
	<div class="refresh-container">
		<div class="loader-pendulums"></div>
	</div>
	<div class="card-header card-header-action pr-0">
		<h6>You know these people ?</h6>

		<div class="d-flex align-items-center card-action-wrap">
			<div class="inline-block pt-2 ">
				<a @click.prevent="suggestions" href="#" class="inline-block refresh mr-15">
					<i class="material-icons">
refresh
</i>
				</a>
				 
			</div>
		</div>
	</div>
	<ul class="list-group list-group-flush">
		<div class="text-center">
			<div v-if="showLoading" class="spinner-grow"  role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
 		<suggested-user v-if="!showLoading" v-for="(user,index) in users" :key="index" :user="user"></suggested-user>
	</ul>
</div>
</template>
<script>
	import { eventBus } from '../../../app'; 
	import SuggestedUser from './User.vue';
	export default{
		components:{
			SuggestedUser:SuggestedUser
		},
		data(){
			return{
				showLoading:true,
				users:[]
			}
		},
		methods:{
			suggestions(){
				this.showLoading=true;
				axios.post('/api/follow.suggestions')
					.then(response => {
						this.users=response.data.suggestions;
						this.showLoading=false;
					})
					.catch(error => {
						console.log(error);
					})
			}
		},
		created(){
			this.suggestions();

		}
	}
</script>