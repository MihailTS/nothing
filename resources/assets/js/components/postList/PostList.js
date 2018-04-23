import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import React from 'react';
import PostItem from './PostItem'
import * as actions from './actions';

class PostList extends React.Component{
    componentDidMount() {
        this.initialLoad();
    }

    initialLoad() {
        this.props.getPostsData(0);
    }

    like(){
        console.log('like');
    }

    dislike(){
        console.log('dislike');
    }

    renderPosts(){
        let posts = this.props.posts;
        return Object.keys(posts).map(postID =>
            <PostItem key={postID} like={this.like} dislike={this.dislike} post={posts[postID]}/>
        );
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