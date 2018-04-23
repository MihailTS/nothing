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
        default:
            return state;
    }
};