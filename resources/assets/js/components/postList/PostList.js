import {connect} from 'react-redux';
import ReactDOM from 'react-dom';
import {bindActionCreators} from 'redux';
import React from 'react';
import PostItem from './PostItem'
import * as actions from './actions';

const RATE_TYPE_LIKE = 'like';
const RATE_TYPE_DISLIKE = 'dislike';

class PostList extends React.Component{
    componentDidMount() {
        this.initialLoad();
        window.addEventListener('scroll', this.loadByScroll);

    }
    componentWillUnmount() {
        window.removeEventListener('scroll', this.loadByScroll);
    }
    initialLoad() {
        this.props.getPostsData();
    }

    like = (postID)=>{
        this.props.changeRate(postID,RATE_TYPE_LIKE);
    };

    dislike = (postID)=>{
        this.props.changeRate(postID,RATE_TYPE_DISLIKE);
    };

    renderPosts(){
        let posts = this.props.posts;
        return Object.keys(posts).map(postID =>
            <PostItem key={postID} like={this.like} dislike={this.dislike} post={posts[postID]}/>
        );
    }

    loadByScroll = () => {
        if (
            this.props.posts &&
            !this.props.isLoading
        ) {
            let bottomPosition = ReactDOM.findDOMNode(this)
                .getBoundingClientRect().bottom - window.innerHeight;
            if (bottomPosition <= 200) {
                this.loadMorePosts();
            }
        }
    };

    loadMorePosts = ()=>{
        this.props.getPostsData(this.props.lastID);
    };
    render() {
        return (
            <div className="post-list">
                {
                    this.renderPosts()
                }
                {
                    this.props.isLoading &&
                    <div className="post-list__loader">
                        Loading!
                    </div>
                }
            </div>
        );
    }
}

function mapStateToProps(state) {
    return {
        posts: state.postsListState.posts,
        isLoading: state.postsListState.isLoading,
        lastID: state.postsListState.lastID
    };
}

function mapDispatchToProps(dispatch) {
    return bindActionCreators({
        ...actions,
    }, dispatch);
}
export default connect(mapStateToProps, mapDispatchToProps)(PostList);