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
                <div key={post.id}>
                    <div>{post.content}</div>
                    <div>{post.time_to_die}</div>
                </div>
            );
        }else{
            return null;
        }
    }
    render() {
        return (
            <div>
                {
                    this.props.isLoading &&
                    <div>
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