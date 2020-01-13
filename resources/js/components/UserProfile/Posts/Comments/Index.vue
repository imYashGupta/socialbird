<template>
	 <div class="card card-profile-feed border-top-0 rounded-top-0 shadow-sm shadow-hover-lg" >
        <!-- -->
        <div class="card-body pb-0" >
<!--             <button  class="btn btn-light btn-sm btn-block mb-25" >
                Hide comments
            </button> -->
            <template v-if="DOMloaded">
                <comment v-for="(comment,index) in comments" :comment="comment" :key="index" :index="index"></comment>
                <button v-if="total > comments.length" @click="loadMore" class="btn btn-light btn-sm btn-block mb-25" >
                    Load More
                </button>
            </template>
            <template v-else>
                <div class="text-center">
                    <div class="spinner-grow" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </template>
        </div>
        <div class="card-footer" >
            <div class="media w-100 align-items-center">
                <div class="media-img-wrap d-flex mr-15">
                    <div class="avatar avatar-sm">
                        <img alt="user" class="avatar-img rounded-circle" src="/images/profile/account/1564431435_1.png"/>
                    </div>
                </div>
                <div class="media-body">
                    <textarea v-model="commentText"  @keydown.enter.prevent="create" class="form-control filled-input bg-transparent" placeholder="Leave a comment..." rows="1">
                    </textarea>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Comment from './Comment.vue';
    import {eventBus} from  './../../../../app';
    import {helper} from  './../../../../helper';

    export default{
        props:['id'],
        //id:post id
        components:{
            Comment
        },
        data(){
            return {
                comments:[],
                commentText:'',
                DOMloaded:false,
                nextPageUrl:'',
                total:null,
            }
        },
        methods:{
            create(){
                helper.API.ComposeComment(this.commentText,this.id)
                .then(res => {
                    this.comments.unshift(res.data.comment);
                    this.commentText='';
                })
            },
            loadMore(){
                if (this.nextPageUrl!=null) {
                    axios.post(this.nextPageUrl,{post_id:this.id})
                    .then(res=>{
                        for (var i = 0; i < res.data.comments.data.length; i++ )  {
                            this.comments.push(res.data.comments.data[i]);
                        }
                        this.nextPageUrl=res.data.comments.next_page_url;
                    })

                }
            }
        },
        created(){
            axios.post('/api/comment.fetch2',{post_id:this.id})
            .then(res => {
                this.comments=res.data.comments.data;
                this.nextPageUrl=res.data.comments.next_page_url;
                this.total=res.data.comments.total;
                this.DOMloaded=true;
              
                //console.log(this.total > this.comments.length)
            })
            eventBus.$on('CommentDeleted',index => {
                this.comments.splice(index,1);
            })

        }
    }
</script>