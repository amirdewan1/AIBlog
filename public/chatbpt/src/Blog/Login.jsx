import { useState } from "react";

const Login = () => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log("Logging in with:", { email, password });
  };

  return (
    <div className="flex items-center justify-center py-20 bg-gray-100">
      <div className="p-5 w-full md:max-w-lg lg:max-w-xl bg-white rounded-lg shadow-lg border border-gray-300">
        <h2 className="text-2xl font-bold mb-4 text-center">Login</h2>
        <form onSubmit={handleSubmit} className="flex flex-col">
          <input
            type="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            placeholder="Email"
            className="border p-2 my-2"
          />
          <input
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            placeholder="Password"
            className="border p-2 my-2"
          />
          <button type="submit" className="bg-blue-500 px-3 py-1 text-white rounded">
            Login
          </button>
        </form>
      </div>
    </div>
  );
};

export default Login;
