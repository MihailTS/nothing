import * as actions from "./actionTypes"
import axios from 'axios'
import {getQueryURL,itemsListSchema} from "../../helper";
import {normalize} from 'normalizr';

const POSTS_URL = "/api/v1/posts";

export const getPostsData = (lastPostID) => dispatch => {
    let url;
    let urlParams = {};
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    let token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }
    /*urlParams.head = head ? head : "null";
    if (loadingData && loadingData.currentPage > 0) {
        urlParams.page = loadingData.currentPage + 1;
    }*/

    url = getQueryURL(POSTS_URL, urlParams);

    dispatch(startLoading());
    axios({url: url}).then(response => {
        const normalizedData = normalize(response.data.data, itemsListSchema);
        dispatch(getPosts(normalizedData.entities.items));
    }).catch(error => {
        console.log(error);
    });
};

export const startLoading = () => ({
    type: actions.START_LOADING
});
export const getPosts = (posts) => ({
    type: actions.GET_POSTS,
    posts
});

export const like = (postID) => dispatch => {
    let postURL = POSTS_URL+"/"+postID+"/like";
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    let token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }
    axios({url: postURL}).then(response => {
        console.log(response);
        //dispatch(setLiked(postID));
    }).catch(error => {
        console.log(error);
    });
};


export const dislike = (postID) => dispatch => {
    let postURL = POSTS_URL+"/"+postID+"/dislike";
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    let token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }
    axios({url: postURL}).then(response => {
        console.log(response);
        //dispatch(setDisliked(postID));
    }).catch(error => {
        console.log(error);
    });
};

export const updatePostTime = (data)=>({
    type: actions.UPDATE_POST_TIME,
    data
});