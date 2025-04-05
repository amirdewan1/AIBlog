import { useParams } from "react-router-dom";

const BlogPost = ({ blogs }) => {
  const { id } = useParams();
  const blog = blogs.find((b) => b.id === Number(id));

  if (!blog) return <h2>Blog not found</h2>;

  return (
    <div className="p-5">
      <h1 className="text-3xl font-bold">{blog.title}</h1>
      <p>{blog.content}</p>
    </div>
  );
};

export default BlogPost;
