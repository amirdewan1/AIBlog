import { Link } from "react-router-dom";

const BlogList = ({ blogs }) => {
  return (
    <div className="space-y-8">
      {blogs.map(blog => (
        <div key={blog.id} className="p-6 bg-gray-100 rounded-lg shadow-md">
          <h2 className="text-2xl font-bold">{blog.title}</h2>
          <p className="text-gray-600">{blog.excerpt}</p>
          <Link to={`/blog/${blog.id}`} className="text-green-500 hover:text-green-600">
            Read more...
          </Link>
        </div>
      ))}
    </div>
  );
};

export default BlogList;


