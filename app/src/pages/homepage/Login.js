import React from 'react';
import './Homepage.scss';

function Login(props) {
  return (
    <section className="homepage-style">
      <h2>WebChat</h2>

      <form>
        <input type="text" name="email" placeholder="Email" />
        <input type="password" name="password" placeholder="Password" />

        <button type="submit">LOGIN</button>
      </form>

      <small>
        Not a member ? <span onClick={ () => props.handlePageChange('signUp') }>Sing up now</span>
      </small>
    </section>
  );
}

export default Login;
