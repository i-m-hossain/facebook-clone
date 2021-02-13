<template>

    <div class="w-100 h-64 overflow-hidden">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ-N4mJ1jk14l5TFgFpryR6cQsLLo39v-GaxA&usqp=CAU" 
        alt="" class="object-cover w-full">
    </div>

  
</template>

<script>
    
    export default {

        name: "Show",

        data: () =>{

            return {
            
                user: null,
                loading: true,
                
            }

            

        },

        mounted(){

            axios.get('/api/users/' + this.$route.params.userId )
                .then(res => {

                
                    this.user = res.data;
                    this.loading= false;
                   
                    
                    
                })
                
                .catch(error  => {

                    console.log('failed to fetch');
                     this.loading= false;
                    
                
                })

            // axios.get('/posts' + this.$route.params.userId)
            //     .then(res => {
            //         console.log(res);
            //         this.posts = res.data;
            //         this.loading = false;
                    
            //     })
            //     .catch(error => {
            //         console.log('Unable to fetch posts');
            //     });    
                
    
        }


    }
</script>

<style>

</style>