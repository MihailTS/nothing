import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import React from 'react';
import PostItem from './PostItem'
import * as actions from './actions';
import io from 'socket.io-client';

class PostList extends React.Component{
    componentDidMount() {
        this.initialLoad();
    }

    initialLoad() {
        var socket = io('http://nothing.com:3000');
        socket.on('post-channel:PostUpdateTime', (data)=>{
            console.log(data);
            this.props.updatePostTime(data);
        });

        this.props.getPostsData(0);
    }


    renderPosts(){
        let posts = this.props.posts;
        return Object.keys(posts).map(postID =>
            <PostItem key={postID} like={this.props.like} dislike={this.props.dislike} post={posts[postID]}/>
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