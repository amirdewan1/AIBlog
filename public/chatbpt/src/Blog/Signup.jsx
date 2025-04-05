import { useState } from "react";

const Signup = () => {
  const [username, setUsername] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log("Signing up with:", { username, email, password });
  };

  return (
    <div className="p-5 max-w-md mx-auto">
      <h2 className="text-2xl font-bold">Sign Up</h2>
      <form onSubmit={handleSubmit} className="flex flex-col">
        <input type="text" value={username} onChange={(e) => setUsername(e.target.value)} placeholder="Username" className="border p-2 my-2" />
        <input type="email" value={email} onChange={(e) => setEmail(e.target.value)} placeholder="Email" className="border p-2 my-2" />
        <input type="password" value={password} onChange={(e) => setPassword(e.target.value)} placeholder="Password" className="border p-2 my-2" />
        <button type="submit" className="bg-blue-500 px-3 py-1 text-white rounded">Sign Up</button>
      </form>
    </div>
  );
};

export default Signup;
