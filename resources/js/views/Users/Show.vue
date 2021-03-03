<template>
    <div class=" flex flex-col items-center"  v-if="status.user === 'success' && user">
       
        <div class="relative mb-8">
            <div class="w-100 h-64 overflow-hidden z-10">
               <UploadableImage  image-width="1200"
                                 image-height="500"
                                 location="cover"
                                 alt="user background image"
                                 classes="object-cover w-full"
                                 :user-image="user.data.attributes.cover_image"/>
            </div>

            <div class=" absolute flex  bottom-0 left-0 -mb-8 items-center ml-12 z-20">
                <UploadableImage image-width="750"
                                 image-height="750"
                                 location="profile"
                                 alt="user profile pricture"
                                 classes="object-cover rounded-full h-32 w-32 shadow-lg border-4 border-gray-200"
                                 :user-image="user.data.attributes.profile_image"/>
                <p class=" text-2xl text-gray-100 ml-4">{{ user.data.attributes.name }} </p>
    
            </div>

            <div class="absolute flex  bottom-0 right-0 mb-4 items-center mr-12 z-20">
                <button v-if="friendButtonText  && friendButtonText !== 'Accept'" 
                    class="px-3 py-1 bg-gray-400 rounded"
                    @click="$store.dispatch('sendFriendRequest',$route.params.userId)" >

                    {{ friendButtonText }}
                </button>
                <button v-if="friendButtonText  && friendButtonText === 'Accept'" 
                    class="mr-2 px-3 py-1 bg-blue-500 rounded"
                    @click="$store.dispatch('acceptFriendRequest',$route.params.userId)" >

                    Accept
                </button>
                <button v-if="friendButtonText  && friendButtonText === 'Accept'"
                    class="px-3 py-1 bg-gray-400 rounded"
                    @click="$store.dispatch('ignoreFriendRequest',$route.params.userId)" >

                    Ignore   
                </button>   
               
            </div>
        </div>
 
        <div v-if="status.posts ==='loading'">Loading posts ...</div> 
        <div v-else-if="posts.length < 1"> No posts found. Get started...</div>
        <Post v-else v-for="(post, postKey) in posts.data" :key="postKey" :post="post" />
        
        
        
    </div> 
</template>

<script>
import UploadableImage from '../../components/UploadableImage';
import Post from '../../components/Post.vue';
import {mapGetters} from 'vuex'
    
    export default {
        
        components: { Post, UploadableImage },

        name: "Show",

        mounted(){

           // fetching users (check actions in profile.js) 
           this.$store.dispatch('fetchUser', this.$route.params.userId); //userId coming from the route

            // fetching user posts

            this.$store.dispatch('fetchUserPosts', this.$route.params.userId); 
                
    
        },
        computed: {

            ...mapGetters({

                  user: 'user', 
                  posts: 'posts',
                  status: 'status',
                  friendButtonText: 'friendButtonText',
            })

        },


    }
</script>

<style>

</style>