import Toastify from "toastify-js";

type ToastType = "success" | "error" | "info";

const colors: Record<ToastType, string> = {
  success: "rgb(var(--success),1)",
  error: "rgb(var(--danger),1)",
  info: "rgb(var(--primary),1)",
};

function show(text: string, type: ToastType, duration = 3000) {
  if (!text) return;
  Toastify({
    text,
    duration,
    gravity: "top",
    position: "right",
    close: true,
    stopOnFocus: true,
    style: { background: colors[type] },
  }).showToast();
}

const toast = {
  success: (text = "", duration?: number) => show(text, "success", duration),
  error: (text = "", duration?: number) => show(text, "error", duration),
  info: (text = "", duration?: number) => show(text, "info", duration),
};

export default toast;
