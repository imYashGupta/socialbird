<template>
<div class="card card-profile-feed">
		<div class="card-header card-header-action">
			<h6><span>Follower <span class="badge badge-soft-primary ml-5">{{users.length}}</span></span></h6>
			<router-link :to="'/user/'+this.$route.params.id+'/followers'" class="font-14 ml-auto">View all</router-link>
		</div>
		<div class="card-body pb-5">
			<div class="hk-row text-center">
				<users v-for="(user,index) in users" :key="index" :user="user"></users>
			</div>
		</div>
</div>
</template>
<script type="text/javascript">
	import Users from "./User.vue";
	export default{
		components:{
			Users
		},
		computed:{
			users(){
				return this.$store.getters.GetUserFollowers;
			}
		},
	}
</script>