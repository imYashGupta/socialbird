<template>
	<div>
		<button @click="request(id)" type="button" class="btn btn-primary btn-rounded shadow-xl shadow-hover">
			<span v-if="spinner" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
			<span v-else class="icon-label pr-1">
				<i class="fas " :class="(isfollow) ? 'fa-user-check' : 'fa-user-plus'"></i>
			</span> 
			{{	isfollow ? 'Following' : 'Follow'}}  
		</button>
	</div>
</template>
<script type="text/javascript">
	export default{
		props:['icon','follow','id'],
		data(){
			return{
				spinner:false,
				isfollow:this.follow,
			}
		},
		methods:{
			request(id){
				this.spinner=true;
				this.$store.dispatch('follow',id)
				.then(res => {
					this.isfollow=res.data.follow;
					this.spinner=false;
				})
			},
		}
	}
</script>