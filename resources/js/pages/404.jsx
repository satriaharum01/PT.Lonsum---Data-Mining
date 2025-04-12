import React from 'react';
import '../../css/app.css'; // kalau kamu punya file CSS custom dari template ini

const NotFound = () => {
  return (
    <div id="notfound">
      <div className="notfound-bg"></div>
      <div className="notfound">
        <div className="notfound-404">
          <h1>404</h1>
        </div>
        <h2>Oops! Page Not Found</h2>
        <form className="notfound-search" onSubmit={(e) => e.preventDefault()}>
        </form>
        <a href="/" className="home-link">Back To Homepage</a>
      </div>
    </div>
  );
};

export default NotFound;
