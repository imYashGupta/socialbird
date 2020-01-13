<template>
	<div v-if="showBtn">
		<div class="dropdown-divider"></div>
		<a  @click.prevent="init" class="dropdown-item" href="#">{{Text}}</a>
	</div>
</template>
<script type="text/javascript">
	export default{
		props:['id','isFollower'],
		data(){
			return{
				showBtn:true,
				isFollow:this.isFollower
			}
		},
		computed:{
			Text(){
				if (this.isFollow) {
					return "Unfollow";
				}
				else{
					return "Follow";
				}
			},

		},
		methods:{
			init(){
				axios.post('/api/follow',{following:this.id})
				.then(res=>{
					//console.log(res);
					if (res.data.follow) {
						this.isFollow=true;
					}
					else{
						this.isFollow=false;
					}
				})
				.catch(er=>{
					console.log(er);
				})
			}
		},
		created(){
			if (this.isFollower==null) {
				this.showBtn=false;
			}
		}
	}
</script>