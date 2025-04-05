// /components/Chatbot.jsx
import { useState } from "react";
import ChatbotIcon from "./chatbotIcon";
import ChatForm from "./ChatForm";
import ChatMessage from "./ChatMessage";
import { information } from "../information";

const Chatbot = () => {
  const [chatHistory, setChatHistory] = useState([{
    hideInChat: true,
    role: "model",
    text: information,
  }]);
  const [showChatbot, setShowChatbot] = useState(false);

  const generateBotResponse = async (history) => {
    const updateHistory = (text) => {
      setChatHistory((prev) => [
        ...prev.filter((msg) => msg.text !== "Processing..."),
        { role: "model", text },
      ]);
    };

    history = history.map(({ role, text }) => ({ role, parts: [{ text }] }));

    const requestOptions = {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ contents: history }),
    };

    try {
      const response = await fetch(import.meta.env.VITE_API_URL, requestOptions);
      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.error?.message || "Something went wrong");
      }

      const data = await response.json();

      // Log the whole data response to investigate its structure
      console.log("API Response Data:", data);

      if (
        data.candidates &&
        data.candidates[0] &&
        data.candidates[0].content &&
        data.candidates[0].content.parts
      ) {
        const apiResponseText = data.candidates[0].content.parts[0].text
          .replace(/\*\*(.*?)\*\*/g, "$1") // Remove bold markers
          .trim();

        updateHistory(apiResponseText);
      } else {
        throw new Error("Invalid response structure: Missing parts");
      }
    } catch (error) {
      console.error("Error:", error);
      updateHistory("Sorry, I encountered an error processing your request.");
    }
  };

  return (
    <div className={`container ${showChatbot ? "show-chatbot" : ""}`}>
      <button onClick={() => setShowChatbot((prev) => !prev)} id="chatbot-toggler">
        <span className="material-symbols-rounded">mode_comment</span>
        <span className="material-symbols-rounded">close</span>
      </button>

      <div className="chatbot-popup">
        <div className="chat-header">
          <div className="header-info">
            <ChatbotIcon />
            <h2 className="logo-text">Amirbot</h2>
          </div>
          <button className="material-symbols-rounded">keyboard_arrow_up</button>
        </div>

        {/* Chat body */}
        <div className="chatbody">
          <div className="message bot-message">
            <ChatbotIcon />
            <p className="message-text">
              Hey human
              <br /> What can I assist you with?
            </p>
          </div>

          {chatHistory.map((chat, index) => (
            <ChatMessage key={index} chat={chat} />
          ))}
        </div>

        {/* Chat footer */}
        <div className="chat-footer">
          <ChatForm
            chatHistory={chatHistory}
            setChatHistory={setChatHistory}
            generateBotResponse={generateBotResponse}
          />
        </div>
      </div>
    </div>
  );
};

export default Chatbot;
