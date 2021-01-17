import './Loading.scss';

function Loading() {
  return (
    <section className="loading-style">
      <div class="ring">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
      </div>

      <small>Loading...</small>
    </section>
  );
}

export default Loading;
