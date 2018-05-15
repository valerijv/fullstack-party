import React from 'react'
import ReactDOM from 'react-dom'
import Login from './login/login'
import App from './common/layout'
import 'typeface-roboto'
import './common.scss'

let login = document.getElementById('login');
if (login) {
  ReactDOM.render(
    <Login />, login
  );
} else {
  ReactDOM.render(
    <App />, document.getElementById('app')
  );
}
