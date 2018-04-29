import * as actions from "./actionTypes"
import axios from 'axios'
import {getQueryURL,itemsListSchema} from "../../helper";
import {normalize} from 'normalizr';
import io from "socket.io-client";

const POSTS_URL = "/api/v1/posts";
const socket = io(':3000');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

export const getPostsData = (lastPostID) => dispatch => {
    let url;
    let urlParams = {};

    if(lastPostID){
        urlParams.from=lastPostID;
    }
    url = getQueryURL(POSTS_URL, urlParams);

    dispatch(startLoading());
    axios({url: url}).then(response => {
        const normalizedData = normalize(response.data.data, itemsListSchema);
        dispatch(getPosts(normalizedData.entities.items));
        
        Object.keys(normalizedData.entities.items).map(postID =>
            {
                socket.on('post-channel:PostUpdateTime'+postID, (data)=>{
                    dispatch(updatePostTime(data));
                });
                setInterval(()=>(dispatch(countDown(postID))),1000);
            }
        );
    }).catch(error => {
        console.log(error);
    });
};


export const countDown = (postID) => {
    return {
        type:actions.COUNT_DOWN,
        postID
    }
};

export const startLoading = () => ({
    type: actions.START_LOADING
});
export const getPosts = (posts) => ({
    type: actions.GET_POSTS,
    posts
});

export const changeRate = (postID, type) => dispatch =>{
    let postURL = `${POSTS_URL}/${postID}"/${type}`;

    axios({url: postURL}).then(response => {
        console.log(response);
        dispatch(setRated(postID,type));
    }).catch(error => {
        console.log(error);
    });
};

export const setRated = (postID,type)=>({
    type: actions.SET_POST_RATED,
    rateType:type,
    postID
});

export const updatePostTime = (data)=>({
    type: actions.UPDATE_POST_TIME,
    data
});