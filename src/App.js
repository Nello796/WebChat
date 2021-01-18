import React from 'react';
import Loading from './components/loading/Loading';
import Login from './pages/homepage/Login';
import SignUp from './pages/homepage/SignUp';

class App extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      page: 'login'
    }

    this.renderPage = this.renderPage.bind(this);
    this.handlePageChange = this.handlePageChange.bind(this);
  }

  renderPage() {

    switch (this.state.page) {
      case 'login':
        return <Login handlePageChange={ this.handlePageChange } />;

      case 'signUp':
        return <SignUp handlePageChange={ this.handlePageChange } />;

      default:
        return <Login handlePageChange={ this.handlePageChange } />;
    }
  }

  handlePageChange($page) {

    this.setState( prevState => ({
      page: prevState.page = $page
    }));
  }

  render() {
    return (
      <div>
        <article>
          <Loading />
        </article>

        <article>
          {this.renderPage()}
        </article>
      </div>
    );
  }
}

export default App;
