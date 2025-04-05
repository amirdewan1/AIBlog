import { useState, useEffect } from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Header from "./side/Header";
import Footer from "./side/Footer";
import Chatbot from "./components/Chatbot";  
import AuthButton from "./Blog/AuthButton"; 

// Blog-related pages
import BlogPage from "./Blog/BlogPage";
import BlogPost from "./Blog/BlogPost";
import CreateBlog from "./Blog/CreateBlog";
import Login from "./Blog/Login";
import Signup from "./Blog/Signup";

function App() {
  const [headerHeight, setHeaderHeight] = useState(0);

  useEffect(() => {
    const updateHeaderHeight = () => {
      const header = document.getElementById("main-header");
      if (header) setHeaderHeight(header.offsetHeight);
    };

    updateHeaderHeight();
    window.addEventListener("resize", updateHeaderHeight);

    return () => window.removeEventListener("resize", updateHeaderHeight);
  }, []);

  return (
    <Router>
      <Header />
      
      {/* Ensure content is dynamic for both desktop and mobile */}
      <main style={{ paddingTop: headerHeight }} className="p-6 bg-gray-100 min-h-screen flex justify-center">
  <div className="w-full max-w-5xl px-4"> {/* Centers content with max width */}
    <h1 className="text-4xl font-bold text-gray-800">Welcome to My Blog</h1>
    <Routes>
      <Route path="/" element={<BlogPage />} />
      <Route path="/blog/:id" element={<BlogPost />} />
      <Route path="/create" element={<CreateBlog />} />
      <Route path="/login" element={<Login />} />
      <Route path="/signup" element={<Signup />} />
    </Routes>
  </div>
</main>


      <AuthButton />
      <Chatbot /> 
      <Footer />
    </Router>
  );
}

export default App;
