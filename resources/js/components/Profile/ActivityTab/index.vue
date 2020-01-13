<template>
<div>
	<div class="hk-pg-header mb-10">
		<div>
			<h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg></span></span>Activity </h4>
		</div>
	</div>
	<div class="row" v-if="DOMloaded">
		<div class="col-xl-12">
			<div class="card card-lg">
				<div class="card-body">
					<div class="user-activity">
						<activity  v-for="(activity,index) in activities" :activity="activity" :key="index"></activity>
						<div v-if="activities.length == 0">This user don't have any activity. </div>
					</div>					 
				</div>
			</div>
		</div>
	</div>
	<div  v-else class="text-center">
		<div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
			<span class="sr-only">Loading...</span>
		</div>
	</div>
</div>
</template>
<script type="text/javascript">
	import activity from './Activity.vue';
	import loader from './../../Loader/FullScreen.vue';
	export default{
		components:{
			activity,loader
		},
		data(){
			return{
				activities:[],
				DOMloaded:false,
			}
		},
		created(){
			 
			axios.get('/api/activity.'+this.$route.params.id)
			.then(response => {
				this.activities=response.data;
				this.DOMloaded=true;
			})
			.catch(error=>{
				console.log(error);
				this.$router.push('/404');
			})
		}
	}
</script>