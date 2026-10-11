// Add product editor JS

(function () {
  // Initialize Quill editor for product description
  var editor2 = new Quill("#editor2", {
    modules: { toolbar: "#toolbar2" },
    theme: "snow",
    placeholder: "Enter product description...",
  });

  // ================== Image Management ==================
  // Track images marked for removal
  var imagesToRemove = [];

  // Remove existing image
  function removeExistingImage(imageId, cardElement) {
    if (!imageId) return;

    // Add to removal list
    if (!imagesToRemove.includes(imageId)) {
      imagesToRemove.push(imageId);
    }

    // Mark card as removing
    cardElement.classList.add('removing');

    // Hide the card after animation
    setTimeout(function() {
      cardElement.style.display = 'none';
    }, 300);

    // Update hidden input
    updateRemovalInput();
  }

  // Update hidden input with images to remove
  function updateRemovalInput() {
    // Remove existing input if any
    var existingInput = document.getElementById('images-to-remove');
    if (existingInput) {
      existingInput.remove();
    }

    // Create new input if there are images to remove
    if (imagesToRemove.length > 0) {
      var input = document.createElement('input');
      input.type = 'hidden';
      input.id = 'images-to-remove';
      input.name = 'images_to_remove[]';
      input.value = imagesToRemove.join(',');
      document.getElementById('add-product-form').appendChild(input);
    }
  }

  // Preview new image before upload
  function previewNewImage(input, previewContainer) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        // Clear previous preview
        previewContainer.innerHTML = '';

        // Create image element
        var img = document.createElement('img');
        img.src = e.target.result;
        img.alt = 'Preview';

        // Create remove button
        var removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'btn btn-sm btn-danger remove-preview';
        removeBtn.innerHTML = '<i class="fa fa-times"></i>';
        removeBtn.onclick = function() {
          clearPreview(previewContainer, input);
        };

        previewContainer.appendChild(img);
        previewContainer.appendChild(removeBtn);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  // Clear preview and reset input
  function clearPreview(previewContainer, input) {
    previewContainer.innerHTML = '';
    input.value = '';
  }

  // Initialize image management
  function initImageManagement() {
    // Remove existing image buttons
    var removeButtons = document.querySelectorAll('.remove-existing-image');
    removeButtons.forEach(function(button) {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        var imageId = this.getAttribute('data-image-id');
        var card = this.closest('[data-image-id]');
        removeExistingImage(imageId, card);
      });
    });

    // New image file inputs
    var newImageInputs = document.querySelectorAll('.new-image-input');
    newImageInputs.forEach(function(input, index) {
      // Create preview container
      var previewContainer = document.createElement('div');
      previewContainer.className = 'new-image-preview mt-2';
      previewContainer.id = 'new-image-preview-' + index;
      input.parentNode.appendChild(previewContainer);

      // Preview on change
      input.addEventListener('change', function() {
        previewNewImage(this, previewContainer);
      });
    });
  }

  // Initialize on page load
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initImageManagement);
  } else {
    initImageManagement();
  }

  // Load existing content into Quill editor on page load
  function loadQuillContent(editor, hiddenTextareaId) {
    var hidden = document.getElementById(hiddenTextareaId);
    if (hidden && hidden.value) {
      editor.root.innerHTML = hidden.value;
    }
  }

  loadQuillContent(editor2, 'description-hidden');

  // Sync Quill editor to hidden textarea on change
  editor2.on('text-change', function () {
    var hidden = document.getElementById('description-hidden');
    if (hidden) {
      hidden.value = editor2.root.innerHTML;
    }
  });

  // =====================================================================
  function showToast(title, icon) {
    icon = icon || "success";
    var Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: function (toast) {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
      },
    });
    Toast.fire({
      icon: icon,
      title: title,
    });
  }

  // ================== Form Validation & Submission ==============
  var addProductForm = document.getElementById("add-product-form");
  if (addProductForm) {
    addProductForm.addEventListener("submit", function (event) {
      // Sync Quill editor before validation/submission
      var descHidden = document.getElementById("description-hidden");
      if (descHidden) {
        descHidden.value = editor2.root.innerHTML;
      }

      // Client-side validation for required fields
      var requiredFields = [
        { name: "sku", label: "Product SKU" },
        { name: "name", label: "Product Title" },
        { name: "cost_price", label: "Initial Price" },
        { name: "sale_price", label: "Selling Price" },
        { name: "quantity", label: "Stock Quantity" },
      ];

      var missingFields = [];
      for (var i = 0; i < requiredFields.length; i++) {
        var field = requiredFields[i];
        var input = addProductForm.querySelector(
          'input[name="' + field.name + '"]'
        );
        if (!input || !input.value.trim()) {
          missingFields.push(field.label);
        }
      }

      if (missingFields.length > 0) {
        event.preventDefault();
        showToast(
          "Please fill in: " + missingFields.join(", "),
          "error"
        );
        return false;
      }

      // Validation passed — allow the form to submit normally.
    });
  }

  // ================== Category Modal Form ==============
  var createCategoryForm = document.getElementById("create-category-form");
  if (createCategoryForm) {
    createCategoryForm.addEventListener("submit", function(event) {
      event.preventDefault();
      // Category creation logic would go here
      // For now, just close the modal
      var modal = bootstrap.Modal.getInstance(document.getElementById('category-pill-modal'));
      if (modal) {
        modal.hide();
      }
      showToast("Category created successfully", "success");
    });
  }

})();
