import React from 'react';
import './Loading.scss';

function Loading() {
  return (
    <section className="loading-style">
      <div className="ring">
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
