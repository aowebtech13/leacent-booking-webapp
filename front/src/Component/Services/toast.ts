import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";

type ToastType = "success" | "error" | "info";

function show(text: string, type: ToastType, duration = 3000) {
  if (!text) return;
  Toastify({
    text,
    duration,
    gravity: "top",
    position: "right",
    close: true,
    stopOnFocus: true,
    className: `app-toastify app-toastify-${type}`,
  }).showToast();
}

const toast = {
  success: (text = "", duration?: number) => show(text, "success", duration),
  error: (text = "", duration?: number) => show(text, "error", duration),
  info: (text = "", duration?: number) => show(text, "info", duration),
};

export default toast;
