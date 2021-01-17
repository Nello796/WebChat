import './Homepage.scss';

function SignUp() {
  return (
    <section className="homepage-style">
      <h2>WebChat</h2>

      <form>
        <input type="text" name="nickname" placeholder="Nickname" />
        <input type="text" name="email" placeholder="Email" />
        <input type="password" name="password" placeholder="Password" />

        <button type="submit">SIGN UP</button>

        <small>
          Already a member ? <span>Login</span>
        </small>
      </form>
    </section>
  );
}

export default SignUp;
