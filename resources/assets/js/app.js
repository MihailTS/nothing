import React from 'react';
import {render} from 'react-dom';
import {Provider} from 'react-redux';
import {BrowserRouter as Router} from 'react-router-dom';
//import Example from './components/Example'
import Posts from './components/posts/Posts'
import store from './store';

render(
    (<Provider store={ store }>
        <Router>
            <Posts/>
        </Router>
    </Provider>)
    , document.getElementById('root')
)