import * as actions from './actionTypes';
const initialState = {
    posts: {},
    isLoading: true,
    lastID: 0
};

export default (state = initialState, action) => {
    console.log(action);
    switch (action.type) {
        case actions.GET_POSTS: {
            let maxID = Object.keys(action.posts)
                .reduce((a, b) => action.posts[a] > action.posts[b] ? a : b);
            return {
                ...state,
                posts: {
                    ...state.posts,
                    ...action.posts,
                },
                isLoading:false,
                lastID: maxID
            };
        }
        case actions.START_LOADING:{
            return {
                ...state,
                isLoading:true
            }
        }
        case actions.UPDATE_POST_TIME:{
            return{
                ...state,
                posts:{
                    ...state.posts,
                    [action.data.id]:{
                        ...state.posts[action.data.id],
                        time_to_die:action.data.time_to_die,
                        time_left:action.data.time_left
                    }
                }
            }
        }
        case actions.SET_POST_RATED:{
            return{
                ...state,
                posts:{
                    ...state.posts,
                    [action.postID]:{
                        ...state.posts[action.postID],
                        rated:action.rateType
                    }
                }
            }
        }
        default:
            return state;
    }
};