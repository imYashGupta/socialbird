<template>
<div>
	<div class="hk-pg-header mb-10">
		<div>
			<h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-ios-today"></i></span> Followings ({{data.total}})</h4>
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
				users:[],
				data:null
			}
		},
		components:{
			Users
		},
		created(){
			axios.post('/api/following.list',{username:this.$route.params.id})
			.then(res =>{
				this.users=res.data.followings.data;
				this.data=res.data.followings;
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