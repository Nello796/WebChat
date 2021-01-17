import './Login.scss';

function Login() {
  return (
    <section className="login-style">
      <h2>WebChat</h2>

      <form>
        <input type="text" name="email" placeholder="Email" />
        <input type="password" name="password" placeholder="Password" />

        <button type="submit">LOGIN</button>
      </form>

      <small>
        Not a member ? <span>Sing up now</span>
      </small>
    </section>
  );
}

export default Login;
