import React from 'react'
import IssueCount from './count'
import IssueList from './list'
import './table.scss'

export default () => (
  <div className="table">
  <IssueCount />
  <IssueList />
  </div>
)