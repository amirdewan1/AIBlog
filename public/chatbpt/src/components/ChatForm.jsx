import { useRef } from "react";

const ChatForm = ({ chatHistory, setChatHistory, generateBotResponse }) => {
  const inputRef = useRef();

  const handleFormSubmit = (e) => {
    e.preventDefault();
    const userMessage = inputRef.current.value.trim();
    if (!userMessage) return;
    inputRef.current.value = "";
  
    // Add the user's message to the chat history
    setChatHistory((history) => [
      ...history,
      { role: "user", text: userMessage },
    ]);
  
    // Add the "Processing..." message to the chat history
    setChatHistory((history) => [
      ...history,
      { role: "model", text: "Processing..." },
    ]);
  
    // Trigger the bot response once
    generateBotResponse([...chatHistory, { role: "user", text: `using the details provided above, please address this query: ${userMessage}` }]);
  };
  

  return (
    <form action="#" className="chat-form" onSubmit={handleFormSubmit}>
      <input ref={inputRef} type="text" placeholder="Message..." className="message-input" required />
      <button className="material-symbols-rounded">keyboard_arrow_up</button>
    </form>
  );
};

export default ChatForm;
