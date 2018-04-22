import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import React from 'react';
import * as actions from './actions';

class PostList extends React.Component{
    componentDidMount() {
        this.initialLoad();
    }

    initialLoad() {
        this.props.getPostsData(0);
    }
    renderPosts(){
        if(this.props.posts){
            return this.props.posts.map((post) =>
                <div className="post" key={post.id}>
                    <div className="post__content">{post.content}</div>
                    <div className="post__time">{post.time_left}</div>
                    <div className="post__btn-panel">
                        <button className="post__btn post__btn_like"/>
                        <button className="post__btn post__btn_dislike"/>
                    </div>
                </div>
            );
        }else{
            return null;
        }
    }
    render() {
        return (
            <div className="post-list">
                {
                    this.props.isLoading &&
                    <div className="post-list__loader">
                        Loading!
                    </div>
                }
                {
                    this.renderPosts()
                }
            </div>
        );
    }
}

function mapStateToProps(state) {
    return {
        posts: state.postsListState.posts,
        isLoading: state.postsListState.isLoading
    };
}

function mapDispatchToProps(dispatch) {
    return bindActionCreators({
        ...actions,
    }, dispatch);
}
export default connect(mapStateToProps, mapDispatchToProps)(PostList);