import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import AuthButton from "../Blog/AuthButton";

const Header = () => {
  const [isScrolled, setIsScrolled] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 50);
    };

    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  return (
    <header
      id="main-header"
      className={`fixed top-0 left-0 w-full z-50 transition-all duration-300 ${
        isScrolled ? "bg-gray-900 shadow-lg" : "bg-gray-900 bg-opacity-90"
      }`}
    >
      <div className="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <Link to="/" className="text-3xl font-extrabold tracking-wide text-gray-200 hover:text-gray-400 transition">
          My Blog
        </Link>

        {/* Responsive Navigation */}
        <nav className="hidden md:flex space-x-6 text-lg font-medium">
          <Link to="/" className="text-gray-300 hover:text-white transition">
            Home
          </Link>
          <Link to="/create" className="text-gray-300 hover:text-white transition">
            Create Blog
          </Link>
        </nav>

        <AuthButton />
      </div>
    </header>
  );
};

export default Header;
