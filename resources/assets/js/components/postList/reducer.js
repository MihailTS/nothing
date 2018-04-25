import * as actions from './actionTypes';
const initialState = {
    posts: {},
    isLoading: true
};

export default (state = initialState, action) => {
    console.log(action);
    switch (action.type) {
        case actions.GET_POSTS: {
            return {
                ...state,
                posts: {
                    ...state.posts,
                    ...action.posts,
                },
                isLoading:false
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