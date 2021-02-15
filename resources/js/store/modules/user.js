import axios from "axios";

        

const state = {

    user: null,
    userStatus: null,
};
const getters = {

    authUser: state  => {
        
        return state.user;
    }

};
const actions = {

    fetchAuthUser({commit, state}) {
        
        axios.get('/api/auth-user/')
            .then(res  => {
                
                console.log("success user vuex");
                commit('setAuthUser', res.data);

            }).catch(error  => {
                console.log("failed to fetch user vuex");
            })
    }

};
const mutations = {
    setAuthUser(state, user) {
        
        state.user = user 
    }

};
      

export default {
    state, getters, mutations, actions
}