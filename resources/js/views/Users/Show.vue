<template>
    <div class=" flex flex-col items-center" >

        <div v-if="userLoading"> Loading User.. </div>
        <div v-if="!userLoading" class="relative mb-8">
            <div class="w-100 h-64 overflow-hidden z-10">
                <img src="https://i.stack.imgur.com/vhoa0.jpg" 
                    alt="User Background Image" class="object-cover w-full">
            </div>

            <div class=" absolute flex  bottom-0 left-0 -mb-8 items-center ml-12 z-20">

                <img src="https://snusercontent.global.ssl.fastly.net/member-profile-full/46/4274246_8809836.jpg" 
                alt="Profile pricture" class="object-cover rounded-full h-32 w-32 shadow-lg border-4 border-gray-200">
                <p class=" text-2xl text-gray-100 ml-4">{{ user.data.attributes.name }} </p>

            </div>

            <div class="absolute flex  bottom-0 right-0 mb-4 items-center mr-12 z-20">
                <button class="px-3 py-1 bg-gray-400 rounded">Add Friend</button>
            </div>
        </div>
 


        <p v-if="postLoading">Loading posts ...</p>
        <Post v-else v-for="post in posts.data" :key="post.data.post_id" :post="post" />
        
        <p v-if="!postLoading && posts.data.length <1"> There is no post</p>
        
    </div> 
</template>

<script>
import Post from '../../components/Post.vue';
import {mapGetters} from 'vuex'
    
    export default {
        
        components: { Post },

        name: "Show",

        data: () =>{

            return {
                
                posts: null,
              
                postLoading: true,               
            }

        },

        mounted(){

           this.$store.dispatch('fetchUser', this.$route.params.userId); //userId coming from the route

            axios.get('/api/users/' + this.$route.params.userId + '/posts')
                .then(res => {

                    console.log("succes post");
                    this.posts = res.data;
                    this.postLoading= false;
                    
                    
                })
                .catch(error => {
                    console.log('Unable to fetch posts');
                    this.postLoading= false;
                                 
                });    
                
    
        },
        computed: {

            ...mapGetters({

                  user: 'user', 
            })

        }


    }
</script>

<style>

</style>