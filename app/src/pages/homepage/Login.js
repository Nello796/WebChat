import React from 'react';
import axios from "axios";

import './Homepage.scss';

class Login extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      email: '',
      password: ''
    }

    this.handleSubmit = this.handleSubmit.bind(this);
    this.handleChangeInputs = this.handleChangeInputs.bind(this);
  }

  handleSubmit(event) {

    axios.post('http://192.168.1.254:8080/WebChat/api/request/login.php', {
        email: this.state.email,
        password: this.state.password
      },
      { 
        withCredentials: true
      })
      .then(function (response) {
        
        console.log(response.data);
      });
  
      event.preventDefault();
  }

  handleChangeInputs(event) {

    const target = event.target.name;
    const value = event.target.value;

    this.setState( prevState => ({
      [target]: prevState[target] = value
    }));
  }

  render() {
    return (
      <section className="homepage-style">
        <h2>WebChat</h2>

        <form onSubmit={ this.handleSubmit }>
          <input type="text" name="email" value={ this.state.email } placeholder="Email" onChange={ this.handleChangeInputs } />
          <input type="password" name="password" value={ this.state.password } placeholder="Password" onChange={ this.handleChangeInputs } />

          <button type="submit">LOGIN</button>
        </form>

        <small>
          Not a member ? <span onClick={ () => this.props.handlePageChange('signUp') }>Sing up now</span>
        </small>
      </section>
    );
  }
}

export default Login;
