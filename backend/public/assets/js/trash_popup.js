// Trash Functionality JS

(function () {
  function attachDeleteHandlers() {
    const deleteIcons = document.querySelectorAll(".trash-3, .trash-4, .trash-5, .trash-6, .trash-7");

    const alertMessages = {
      "trash-3": "Do you really want to delete the product?",
      "trash-4": "Do you really want to delete the API Key?",
      "trash-5": "Do you really want to delete the Customer Review?",
      "trash-6": "Do you really want to delete the role?",
      "trash-7": "Do you really want to delete the name?",
    };

    deleteIcons.forEach(function (icon) {
      // Avoid attaching duplicate handlers
      if (icon.dataset.trashHandlerAttached) {
        return;
      }
      icon.dataset.trashHandlerAttached = "true";

      icon.addEventListener("click", function (event) {
        event.preventDefault();

        const productRow = icon.closest("tr");
        const deleteUrl = icon.getAttribute("data-url");

        let alertMessage = "Do you really want to delete this item?";
        for (const className in alertMessages) {
          if (icon.classList.contains(className)) {
            alertMessage = alertMessages[className];
            break;
          }
        }
        Swal.fire({
          title: "Are you sure?",
          text: alertMessage,
          showCancelButton: true,
          confirmButtonColor: "#16C7F9",
          cancelButtonColor: "#FC4438",
          confirmButtonText: "Yes, delete it!",
          imageUrl: "../assets/images/gif/trash.gif",
          imageWidth: 120,
          imageHeight: 120,
        }).then((result) => {
          if (result.isConfirmed) {
            if (deleteUrl) {
              fetch(deleteUrl, {
                method: "DELETE",
                headers: {
                  "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                  "Accept": "application/json",
                  "Content-Type": "application/json",
                },
              })
              .then((response) => response.json())
              .then((data) => {
                if (data.success) {
                  productRow.style.display = "none";
                  Swal.fire({
                    title: "Deleted!",
                    text: data.message || "Item has been deleted.",
                    icon: "success",
                    confirmButtonColor: "#16C7F9",
                  });
                } else {
                  Swal.fire({
                    title: "Error!",
                    text: data.message || "Failed to delete item.",
                    icon: "error",
                    confirmButtonColor: "#FC4438",
                  });
                }
              })
              .catch(() => {
                Swal.fire({
                  title: "Error!",
                  text: "Failed to delete item.",
                  icon: "error",
                  confirmButtonColor: "#FC4438",
                });
              });
            } else {
              productRow.style.display = "none";
            }
          }
        });
      });
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", attachDeleteHandlers);
  } else {
    attachDeleteHandlers();
  }
})();
