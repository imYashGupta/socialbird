export const helper = {
    API: {
    	GetComments(PostID){
    		return new Promise((resolve, reject) => {
    			axios.post('/api/comment.fetch',{post_id:PostID})
    			.then(doneCallbacks => resolve(doneCallbacks))
    			.catch(failCallbacks => reject(failCallbacks));
    		});
    	},
    	ComposeComment(text,PostId){
    		return new Promise((resolve,reject) =>{
    			axios.post('/api/comment.compose',{post_id:PostId,comment:text})
    			.then(res =>{
    				resolve(res);
    			})
    			.catch(er =>{
    				reject(er);
    			})
    		})
    	},
        DeleteComment(id) {
            return new Promise((resolve, reject) => {
                swal({
                    title: "Are you sure?",
                    text: "Wanted to delete this comment. you'll not be able to undo it",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                	if (willDelete) {
		                axios.post('/api/comment.delete', {
		                    commentId: id
		                }).then(response => {
		                    resolve(response)
		                }).catch(err => {
		                    reject(err);
		                })
                	}
                });
            });
        },
        UpdateComment(text,id){
        	return new Promise((resolve,reject) =>{
        		axios.post('/api/comment.edit',{id:id,comment:text})
        		.then(res => {
        			resolve(res);
        		})
        		.catch(er =>{
        			reject(er);
        		})
        	});
        },
        LoadMoreComments(data){
        	 
        	return new Promise((resolve,reject) =>{
        		axios.post(data.url,{post_id:data.PostID,comment:data.comment})
        		.then(res => {resolve(res)})
        		.catch(er => {reject(er)})
        	})
        },
        UpdatePost(post){
            return new Promise((resolve,reject) => {
                axios.post('/api/post.update',{body:post.body,id:post.id})
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error)
                });
            });
        },
        DeletePost(PostID){
            return new Promise((resolve, reject) => {
                axios.post('/api/post.delete',{id:PostID})
                .then(res => {
                    resolve(res)
                })
                .catch(err => {
                   reject(err)
                });
            });
        },
        React(PostID){
            return new Promise((resolve,reject) => {
                axios.post('/api/react',{postID:PostID})
                .then(response => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
            })
        },
    },
    Notice:{
    	Error(){
    		swal("Hang up...","Something goes really wrong! but we're trying fixing it.",'error');
    	}
         
    }
}