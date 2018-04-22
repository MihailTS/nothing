import {combineReducers} from 'redux';
import postListReducer from './components/postList/reducer';

export default combineReducers({
    postsListState: postListReducer,
});
