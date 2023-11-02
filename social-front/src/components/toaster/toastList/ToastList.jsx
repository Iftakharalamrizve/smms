import React, { useEffect, useRef, useState } from "react";
import Toast from "../toast/Toast";

const ToastList = ({ data }) => {
  const position = "top-right";
  const listRef = useRef(null);
  const [toasts, setToasts] = useState([]);

  const handleScrolling = (el) => {
    if (el) {
      el.scrollTo(0, el.scrollHeight);
    }
  };

  useEffect(() => {
    handleScrolling(listRef.current);
    setToasts([data]);
    setTimeout(() => {
      removeToast();
    }, 5 * 1000);
  }, [data]);
  
  const removeToast = () => {
    setToasts([]);
  };

  return (
    <div
      className={`toast-list toast-list--${position}`}
      aria-live="assertive"
      ref={listRef}
    >
      {toasts.map((toast, index) => (
        <Toast
          key={index}
          message={toast.message}
          type={toast.type}
          onClose={() => removeToast()}
        />
      ))}
    </div>
  );
};

export default ToastList;