import React from 'react'
import './issue-count.scss'
import axios from 'axios'
import './list.scss'

export default class extends React.Component {
  constructor() {
    super();
    this.state = {
      items: [],
      page: 1,
    }
  }

  componentDidMount () {
    this.getItems()
  }

  getItems () {
    this.setState({
      items: [],
    }, () => {
      this.serverRequest = axios.get('issues', {params: {page: this.state.page}})
        .then(result => {
          this.setState({
            items: result.data,
          })
        })
    })
  }

  setPage (page) {
    this.setState({
      page: this.state.page + page,
    }, () => {
      this.getItems()
    })
  }

  componentWillUnmount () {
    this.serverRequest.abort()
  }

  render () {
    return (
      <div className="issue-list">
        { this.state.items.map((issue, issueIndex) => {
          return <div className="issue" key={issueIndex.toString()}>
            <div className="issue-title">
              { issue.title }
              { issue.labels.map((label, labelIndex) => {
                let style = {
                  background: '#' + label.color
                }
                return <span
                  className="issue-label"
                  style={style}
                  key={labelIndex.toString()}
                >{label.name}</span>
              }) }
            </div>
            <div className="issue-info">
              { issue.number } opened { issue.human_date } by
              <span className="issue-user"> { issue.user.login }</span>
            </div>
          </div>
        }) }
        <div className="pagination">
          { this.state.page > 1 && <div className="pager-btn" onClick={() => this.setPage(-1)}>Prev</div> }
          <div className="pager-btn" onClick={() => this.setPage(1)}>Next</div>
        </div>
      </div>
    )
  }
}