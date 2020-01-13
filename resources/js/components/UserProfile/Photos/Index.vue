<template>
<div>
	<div class="hk-pg-header mb-10">
		<div>
			<h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg></span></span>Photos </h4>
		</div>
	</div>
	<div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper hk-gallery-wrap">
                            <ul class="nav nav-light nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a href="#" @click.prevent="swictTab('all')" class="nav-link" :class="(tab=='all') ? 'active' : ''">Library</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" @click.prevent="swictTab('profile')" class="nav-link" :class="(tab=='profile') ? 'active' : ''">Profile Pictures</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" @click.prevent="swictTab('posts')" class="nav-link" :class="(tab=='posts') ? 'active' : ''">Posts</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="#" @click.prevent="swictTab('all')" class="nav-link" :class="(tab=='all') ? 'active' : ''">Video</a>
                                </li> -->
                            </ul>
                            <div class="tab-content">
								<loader v-if="loading"></loader>
                                <div class="tab-pane fade show active" role="tabpanel" v-else>
                                    <h6   class="mt-30 mb-20">{{tabName}}</h6>
                                    <div class="row hk-gallery">
                                        <div v-if="images.length==0">
		                                    <div class="card card-lg"><div class="card-body"><div  > <div>This user don't have any Photos in this Category. </div></div></div></div>
                                        </div>
                                        <div v-else  v-for="image in images"  class="col-lg-4 col-md-4 col-sm-4 col-6 mb-10" >
											 <img id="img" v-if="image.type=='account'" data-action="zoom" :src="'/images/profile/account/'+image.name" >
											 <img id="img" v-if="image.type=='post'" data-action="zoom" :src="'/images/posts/'+image.name" >
                                        </div>
                                    </div>
								</div>
                            </div>
                        </section>
                    </div>
                </div>
</div>
</template>
<script type="text/javascript">
	import Loader from './../../Loader/FullScreen.vue'
	export default{
		data(){
			return {
				images:null,
				allImages:null,
				tab:'',
				tabName:'',
				loading:true,
			}
		},
		components:{
			Loader
		},
		methods:{
			openImg(id){
				$("#"+id).click();
				$("#"+id).css({
					display: 'block',
			 
				});;
			},
			swictTab(tab){
				this.LoadTab(tab);
			},
			LoadTab(tab){
				this.tab=tab;
				if (tab=='all') {
					this.tabName="All Photos";
					this.images=this.allImages.all;
				}
				if (tab=='posts') {
					this.tabName="Posts Images";
					this.images=this.allImages.posts;
				}
				if (tab=='profile') {
					this.tabName="Profile Pictures";
					this.images=this.allImages.profile;
				}
			}
		},
		 created(){
		 	axios.post('/api/user.images',{username:this.$route.params.id,type:'all'})
		 	.then((response) => {
		 		//console.log(response)
		 		this.allImages=response.data.photos;
		 		this.LoadTab('all');
		 		this.loading=false;
		 	})
		 	.catch(err => {
		 		console.log(err);
		 	})
		 }
	}
</script>
<style scoped="" type="text/css">
	img{
		min-height: 160px;
    max-width: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
	}

	 .crop {
        width: 200px;
        height: 150px;
        overflow: hidden;
    }

    .crop img {
        width: 400px;
        height: 300px;
        margin: -75px 0 0 -100px;
    }
</style>