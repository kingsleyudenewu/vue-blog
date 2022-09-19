import {createStore} from "vuex";
import axiosClient from "../axios";

const store  = createStore({
    state:{
        user:{
            data:{},
            token:sessionStorage.getItem('TOKEN')
        },
        posts: [],
        links: []
    },
    getters:{
        getAllPosts: state => state.posts,

        getUserPosts: (state) => {
            return state.posts;
        }
    },
    actions:{
        register({commit}, user) {
            return axiosClient.post('/auth/register', user).then(({data}) => {
                commit("setUser", data);
                return data;
            });
        },

        login({commit}, user) {
            return axiosClient.post('/auth/login', user).then(({data}) => {
                commit("setUser", data);
                return data;
            }).catch(err => {
                return err.response.data;
            });
        },

        logout ({commit}) {
            return axiosClient.post('/logout').then(({data}) => {
                commit("logout");
                return data;
            }).catch(err => {
                return err;
            });
        },

        getPosts({commit}, {url = null} = {}) {
            url = url || "/posts";
            return axiosClient.get(url).then(({data}) => {
                commit("posts", data);
                return data;
            }).catch(err => {
                return err;
            });
        },

        getUserPosts({commit}, {url = null} = {}) {
            url = url || 'posts/my-post';

            return axiosClient.get(url).then(({data}) => {
                commit("posts", data);
                return data;
            }).catch(err => {
                return err;
            });
        },

        createPost({commit, dispatch}, post){
            return axiosClient.post('/posts', post).then(({data}) => {
                dispatch('getUserPosts')
                return data;
            }).catch(err => {
                return err.response.data;
            });
        }
    },
    mutations:{
        logout: (state) => {
            state.user.data = {};
            state.user.token = null;
            sessionStorage.removeItem('TOKEN');
        },
        setUser: (state, userData) => {
            state.user.token = userData.data.token;
            state.user.data = userData.data.user;
            sessionStorage.setItem('TOKEN', state.user.token)
        },
        posts: (state, postData) => {
            state.posts = postData.data;
            state.links = postData.meta.links;
        }
    }
});

export default store;
