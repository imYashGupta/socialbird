<template>
<li class="list-group-item border-0">
	<div class="media align-items-center">
		<div class="d-flex media-img-wrap mr-15">
			<avatar :avatar="{size:'sm',firstname:user.user.firstname,lastname:user.user.lastname,color:user.user.avatar,image:user.user.images}"></avatar>
		</div>
		<div class="media-body"><span class="d-block text-dark text-capitalize">{{ user.user.firstname+' '+user.user.lastname }}</span> <span class="d-block font-13">{{user.user.usermeta.title}}</span></div>
		<a href="#" @click.prevent="followUser(user.user.id)" class="text-light-40 ml-auto">
			<span v-if="!showLoading">
				<i v-if="!user.user.follower && user.user.follower!=null" class="ion ion-md-add font-24"></i>
				<i v-if="user.user.follower && user.user.follower!=null" class="text-primary ion ion-md-checkmark font-24"></i>
			</span>
			<div v-if="showLoading" class="spinner-grow spinner-grow-sm" role="status">
				<span  class="sr-only">Loading...</span>
			</div>
		</a>
	</div>
</li>
</template>
<script>
	import Avatar from './../../Elements/Avatar.vue'
	export default{
		components:{
			Avatar
		},
		props:['user'],
		data(){
			return{
				showLoading:false
			}
		},
		methods:{
			followUser(id){
				this.showLoading=true;
				this.$store.dispatch('follow',id)
				.then((response) => {
					if (response.data.follow==true) {
						this.user.user.follower=true;
					}
					else if(response.data.follow==false){
						this.user.user.follower=false;
					}
					else{
						this.user.user.follower=null;
						swal("We Got an Error","You can inform us in our Feedback section with screenshots","error");
					}
					this.showLoading=false;
				})
				.catch(error => {
					swal("We Got an Error","You can inform us in our Feedback section with screenshots","error");
					console.log(error);
				})
			}
		}
	}
</script>