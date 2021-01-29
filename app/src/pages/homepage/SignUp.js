import React from "react";
import axios from "axios";

import "./Homepage.scss";

class SignUp extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      username: '',
      email: '',
      password: ''
    }

    this.handleSubmit = this.handleSubmit.bind(this);
    this.handleChangeInputs = this.handleChangeInputs.bind(this);
  }

  handleSubmit(event) {

    axios.post('http://192.168.1.254:8080/WebChat/api/request/createUser.php', {
        username: this.state.username,
        email: this.state.email,
        password: this.state.password
      })
      .then(function (response) {
        // handle success
        console.log(response.data);
      })
      .catch(function (error) {
        // handle error
        console.log(error);
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

  render () {
    return (
      <section className="homepage-style">
        <h2>WebChat</h2>

        <form onSubmit={ this.handleSubmit }>
          <input type="text" name="username" value={ this.state.username } placeholder="Username" onChange={ this.handleChangeInputs } />
          <input type="text" name="email" value={ this.state.email } placeholder="Email" onChange={ this.handleChangeInputs } />
          <input type="password" name="password" value={ this.state.password } placeholder="Password" onChange={ this.handleChangeInputs } />

          <button type="submit">SIGN UP</button>

          <small>
            Already a member ?{" "}
            <span onClick={ () => this.props.handlePageChange("login") }>Login</span>
          </small>
        </form>
      </section>
    );
  }
}

export default SignUp;
