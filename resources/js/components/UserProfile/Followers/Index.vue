<template>
<div>
	<div class="hk-pg-header mb-10">
		<div>
			<h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-ios-today"></i></span> Followers</h4>
		</div>
	</div>
	<div class="row">
		<users v-for="(user,index) in users" :key="index" :user="user"></users>
	</div>
</div>
</template>
<script type="text/javascript">
	import Users from "./User.vue";
	export default{
		data(){
			return{
				users:[]
			}
		},
		components:{
			Users
		},
		created(){
			this.$store.dispatch('FollowerList',{username:this.$route.params.id})
			.then(res =>{
				this.users=res.data.followers;
			})
		}
	}
</script>
<style type="text/css" scoped="">
	.avatar{
		height: 5rem;
		width: 5rem;
	}

	.padding{
		padding-bottom: 12px !important;
		padding-top: 12px !important;
		padding-left: 20px !important;
		padding-right: 20px !important;
	}
</style>