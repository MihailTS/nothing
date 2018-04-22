import React from 'react';
import PostList from '../postList/PostList'

export default class Posts extends React.Component{
    render(){
        return (
            <div id="posts-list">
                <PostList/>
            </div>
        )
    }
}