import * as actions from './actionTypes';
const initialState = {
    posts: {},
    isLoading: true,
    lastID: 0
};

const countDownPost=(post)=>{
    if(post && post.time_left_ext){
        const secondsOF = post.time_left_ext.seconds===0;
        const minutesOF = post.time_left_ext.minutes===0;
        const hoursOF = post.time_left_ext.hours===0;

        post.time_left_ext.seconds = secondsOF?59:(post.time_left_ext.seconds-1);

        if(secondsOF){
            post.time_left_ext.minutes=minutesOF?59:(post.time_left_ext.minutes-1);
            if(minutesOF){
                post.time_left_ext.hours=hoursOF?23:(post.time_left_ext.hours-1);
                if(hoursOF){
                    post.time_left_ext.days=post.time_left_ext.days-1;
                }
            }
        }

        post.time_left = formatTime(
            [
                post.time_left_ext.hours,
                post.time_left_ext.minutes,
                post.time_left_ext.seconds
            ]
        );
    }
    return post;
};
const formatTime = (timeArr)=>{
    let formattedTime="";
    for(let i in timeArr){
        formattedTime+=((timeArr[i] < 10)?"0":"")+timeArr[i];
        if(i<timeArr.length-1){
            formattedTime+=":";
        }
    }

    return formattedTime;
};
export default (state = initialState, action) => {
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
                        time_left:action.data.time_left,
                        time_left_ext:action.data.time_left_ext
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
        case actions.COUNT_DOWN:{
            return{
                ...state,
                posts:{
                    ...state.posts,
                    [action.postID]:countDownPost(state.posts[action.postID])
                }
            }
        }
        default:
            return state;
    }
};