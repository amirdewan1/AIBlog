import BlogList from "../Blog/BlogList";

const BlogPage = () => {
  const blogs = [
    { id: 1, title: "First Blog", excerpt: "This is the first blog...", content: "Full content here." },
    { id: 2, title: "Second Blog", excerpt: "This is the second blog...", content: "Full content here." },
  ];

  return (
    <div className="min-h-screen flex flex-col items-center bg-gradient-to-b from-[#E0F7FA] to-[#A5D6A7]">
      <main className="w-full max-w-screen-xl bg-white p-10 rounded-lg shadow-lg mt-20">
        <BlogList blogs={blogs} />
      </main>
    </div>
  );
};

export default BlogPage;
