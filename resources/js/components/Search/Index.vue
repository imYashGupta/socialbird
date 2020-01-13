<template>
	<div class="container mt-25">
		<div class="hk-pg-header mb-10"><div><h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-ios-search"></i></span>Search For : <strong> {{query}}</strong>	</h4></div> <div class="d-flex  "><button class="btn btn-light btn-sm  ">Home</button></div></div>

			<loader v-if="showLoader"></loader>
		<div class="row" v-else>
			<div v-if="results.length==0">
				<p>No User found</p>
			</div>
			<user v-else v-for="(user,index) in results" :key="index" :user="user"></user>
		</div>
	</div>
</template>
<script type="text/javascript">
	import {eventBus} from './../../app'
	import Loader from './../Loader/FullScreen.vue'
	import User from './User.vue';
	export default{
		components:{
			User,Loader
		},
		data(){
			return{
				type:'user',
				results:[],
				showLoader:false,
				total:''
			}
		},
		computed:{
			query(){
				return this.$route.query.query;
			},
		},
		watch:{
			query(){
			 
			}
		},
		created(){
 
			let searchData={
				"text" : this.query,
				"type"	: this.type
			}

			axios.post('/api/search',searchData)
			.then(res => {
				this.results=res.data.user;
				this.total=res.data.results;
			})
			
			eventBus.$on('searchResult',(data) =>{
				this.results=data.user;
				this.total=data.results;
				this.showLoader=false;
			})
			eventBus.$on('searchInit',_ =>{
				this.showLoader=true;
			})

		}
	}
</script>