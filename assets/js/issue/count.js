import React from 'react'
import './issue-count.scss'
import axios from 'axios'

export default class extends React.Component {
  constructor() {
    super();
    this.state = {
      open: '',
      closed: ''
    }
  }

  componentDidMount () {
    this.serverRequest = axios.get('issues-count')
      .then(result => {
        this.setState({
          open: result.data.open,
          closed: result.data.closed
        })
      })
  }

  componentWillUnmount () {
    this.serverRequest.abort()
  }

  render () {
    return (
      <div className="issue-count">
        <div className="issue-open">
          <i className="fa fa-exclamation-circle"></i>
          {this.state.open} Open
        </div>
        <div className="issue-closed">
          <i className="fa fa-check-circle-o"></i>
          {this.state.closed} Closed
        </div>
      </div>
    )
  }
}