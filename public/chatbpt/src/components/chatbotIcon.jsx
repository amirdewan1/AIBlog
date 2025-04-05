const ChatbotIcon = () => {
  return (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 200 200"
      width="50" /* Reduced size */
      height="50" /* Reduced size */
      fill="none"
    >
      {/* Speech Bubble Background */}
      <rect
        x="20"
        y="20"
        width="160"
        height="130"
        rx="20"
        fill="#4CAF50"
      />
      {/* Tail of Speech Bubble */}
      <polygon points="80,150 100,170 100,150" fill="#4CAF50" />
      {/* Chatbot Face */}
      <circle cx="70" cy="80" r="10" fill="white" />
      <circle cx="130" cy="80" r="10" fill="white" />
      <rect x="70" y="105" width="60" height="10" rx="5" fill="white" />
    </svg>
  );
};

export default ChatbotIcon;
