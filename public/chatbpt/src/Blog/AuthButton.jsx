import { useState } from "react";
import { Link } from "react-router-dom";

const AuthButton = () => {
  const [user, setUser] = useState(null);

  const handleLogout = () => {
    setUser(null);
  };

  return (
    <div>
      {user ? (
        <>
          <span className="mr-3">Hello, {user.username}</span>
          <button onClick={handleLogout} className="bg-red-500 px-3 py-1 text-white rounded">Logout</button>
        </>
      ) : (
        <div>
          <Link to="/login" className="bg-green-500 px-3 py-1 text-white rounded mx-1">Login</Link>
          <Link to="/signup" className="bg-blue-500 px-3 py-1 text-white rounded">Sign Up</Link>
        </div>
      )}
    </div>
  );
};

export default AuthButton;
