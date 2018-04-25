import React from 'react';

const PostItem = (props) => (
    <div className="post">
        <div className="post__content">{props.post.content}</div>
        <div className="post__time">{props.post.time_left}</div>
        <div className="post__btn-panel">
            <button onClick={props.like.bind(this, props.post.id)}
                    className={"post__btn post__btn_like"+
                        ((props.post.rated==='like')?" post__btn_pressed":"")+
                        ((props.post.rated==='dislike')?" post__btn_disabled":"")
                    }
                    disabled={props.post.rated}
            />
            <button onClick={props.dislike.bind(this, props.post.id)}
                    className={"post__btn post__btn_dislike"+
                        ((props.post.rated==='dislike')?" post__btn_pressed":"")+
                        ((props.post.rated==='like')?" post__btn_disabled":"")
                    }
                    disabled={props.post.rated}
            />
        </div>
    </div>
);

export default PostItem;
