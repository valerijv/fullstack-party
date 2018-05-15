import React from 'react'
import Logo from './logo'
import Logout from './logout'
import Table from '../issue/table'
import './layout.scss'

export default () => (
  <div>
    <div className="header">
      <Logo />
      <Logout />
    </div>
    <Table />
  </div>
);