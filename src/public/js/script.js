// cookie banner
$(document).ready(function () {
  const $banner = $("#cookieBanner");
  if (!$banner.length) {
    return;
  }
  const consent = localStorage.getItem("cookie_consent");
  if (!consent) {
    $banner.removeClass("d-none");
  }
  $("#cookieAccept").on("click", function () {
    localStorage.setItem("cookie_consent", "all");
    $banner.addClass("d-none");
    enableAnalytics();
  });
  $("#cookieReject").on("click", function () {
    localStorage.setItem("cookie_consent", "necessary");
    $banner.addClass("d-none");
  });
  function enableAnalytics() {
    const consent = localStorage.getItem("cookie_consent");
    if (consent !== "all") {
      return;
    }
    console.log("Analytics enabled");
  }
});

// modal confirm
let confirmForm = null;
let previousModal = null;

$(document).on("submit", "form[data-confirm]", function (e) {
  e.preventDefault();

  confirmForm = this;

  const message = $(this).attr("data-confirm") || "Are you sure?";
  $("#confirmModalMessage").text(message);

  previousModal = $(this).closest(".modal")[0] || null;
  if (previousModal) {
    const previousModalInstance = bootstrap.Modal.getInstance(previousModal);

    if (previousModalInstance) {
      previousModalInstance.hide();
    }
  }
  if (previousModal) {
    $(previousModal).one("hidden.bs.modal", function () {
      openConfirmModal();
    });
  } else {
    openConfirmModal();
  }
});

function openConfirmModal() {
  const confirmModalElement = document.getElementById("confirmModal");
  const confirmModal = bootstrap.Modal.getOrCreateInstance(confirmModalElement);
  confirmModal.show();
}

function closeConfirmModal() {
  const confirmModalElement = document.getElementById("confirmModal");
  const confirmModal = bootstrap.Modal.getInstance(confirmModalElement);

  if (
    document.activeElement &&
    confirmModalElement.contains(document.activeElement)
  ) {
    document.activeElement.blur();
  }

  if (confirmModal) {
    confirmModal.hide();
  }
}

$(document).on("click", "#confirmModalOk", function () {
  if (!confirmForm) {
    closeConfirmModal();
    return;
  }

  const form = confirmForm;
  confirmForm = null;
  closeConfirmModal();
  HTMLFormElement.prototype.submit.call(form);
});

$(document).on("click", "#confirmModalCancel, #confirmModalClose", function () {
  closeConfirmModal();

  if (previousModal) {
    const modalToReopen = previousModal;
    previousModal = null;

    $("#confirmModal").one("hidden.bs.modal", function () {
      const modal = bootstrap.Modal.getOrCreateInstance(modalToReopen);
      modal.show();
    });
  }

  confirmForm = null;
});

// autocomplete
$(document).on("focus", "[data-autocomplete-target]", function () {
  const targetId = $(this).data("autocomplete-target");
  const $results = $("#" + targetId);

  if ($results.children().length > 0) {
    $results.prop("hidden", false);
    $(this).attr("aria-expanded", "true");
  }
});

$(document).on("input", "[data-autocomplete-target]", function () {
  const $input = $(this);
  const value = $input.val().trim();
  const url = $input.data("autocomplete-url");
  const searchParam = $input.data("autocomplete-search-param") || "search";
  const targetId = $input.data("autocomplete-target");
  const min = Number($input.data("autocomplete-min")) || 2;
  const $results = $("#" + targetId);

  if (value.length < min) {
    $results.empty().prop("hidden", true);
    $input.attr("aria-expanded", "false");
    return;
  }

  if (!url) return;

  const params = new URLSearchParams({
    [searchParam]: value,
  });

  fetch(`${url}?${params}`)
    .then((response) => response.json())
    .then((data) => {
      $results.empty();

      if (Array.isArray(data) && data.length > 0) {
        data.forEach((item) => {
          const label = item.label || item.title || item.name || "";
          const subtitle = item.subtitle || item.author || item.email || "";
          const val = item.value || label;

          const $option = $(`
            <button
              type="button"
              class="dropdown-item p-3 border-bottom"
              data-autocomplete-option="${val}"
              data-label="${label}">
              <div class="fw-semibold">${label}</div>
              ${subtitle ? `<small class="text-body-secondary">${subtitle}</small>` : ""}
            </button>
          `);
          $results.append($option);
        });

        $results.prop("hidden", false);
        $input.attr("aria-expanded", "true");
      } else {
        $results.prop("hidden", true);
        $input.attr("aria-expanded", "false");
      }
    })
    .catch((err) => {
      console.error("Autocomplete fetch error:", err);
      $results.prop("hidden", true);
      $input.attr("aria-expanded", "false");
    });
});

$(document).on("click", function (event) {
  $("[data-autocomplete-target]").each(function () {
    const $input = $(this);
    const targetId = $input.data("autocomplete-target");
    const $results = $("#" + targetId);

    if (
      !$(event.target).closest($input).length &&
      !$(event.target).closest($results).length
    ) {
      $results.prop("hidden", true);
      $input.attr("aria-expanded", "false");
    }
  });
});

$(document).on("click", "[data-autocomplete-option]", function () {
  const value = $(this).data("autocomplete-option");
  const $results = $(this).closest("[role='listbox']");
  const targetId = $results.attr("id");
  const $input = $(`[data-autocomplete-target="${targetId}"]`);

  $input.val(value);
  $input.attr("aria-expanded", "false");
  $results.prop("hidden", true);
});

// theme
$(document).ready(function () {
    const $html = $('html');
    const $button = $('.theme-toggle');
    const savedTheme = localStorage.getItem('theme');

    if (savedTheme) {
        $html.attr('data-bs-theme', savedTheme);
    }
    updateIcon();
    $button.on('click', function () {
        const currentTheme = $html.attr('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        $html.attr('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateIcon();
    });

    function updateIcon() {
        const theme = $html.attr('data-bs-theme');
        
        if (theme === 'dark') {
            $button.html('<i class="bi bi-sun"></i>');
        } else {
            $button.html('<i class="bi bi-moon"></i>');
        }
    }

});

// dropdown
document.querySelectorAll('.dropdown').forEach(dropdown => {
    dropdown.addEventListener('click', event => {
        event.stopPropagation();
    });
});
