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

// theme
$(document).ready(function () {
  const $html = $("html");
  const $button = $(".theme-toggle");
  const savedTheme = localStorage.getItem("theme");

  if (savedTheme) {
    $html.attr("data-bs-theme", savedTheme);
  }
  updateIcon();
  $button.on("click", function () {
    const currentTheme = $html.attr("data-bs-theme");
    const newTheme = currentTheme === "dark" ? "light" : "dark";
    $html.attr("data-bs-theme", newTheme);
    localStorage.setItem("theme", newTheme);
    updateIcon();
  });

  function updateIcon() {
    const theme = $html.attr("data-bs-theme");

    if (theme === "dark") {
      $button.html('<i class="bi bi-sun"></i>');
    } else {
      $button.html('<i class="bi bi-moon"></i>');
    }
  }
});

// dropdown
document.querySelectorAll(".dropdown").forEach((dropdown) => {
  dropdown.addEventListener("click", (event) => {
    event.stopPropagation();
  });
});

// autocomplete
$(document).ready(function () {
  let debounceTimeout = null;

  $(document).on("input focus", "input[data-autocomplete-url]", function () {
    const $input = $(this);
    const url = $input.attr("data-autocomplete-url");
    const searchParam =
      $input.attr("data-autocomplete-search-param") || "search";
    const targetId = $input.attr("data-autocomplete-target");
    const minLength = parseInt($input.attr("data-autocomplete-min") || "2", 10);
    const $target = $("#" + targetId);

    if (!$target.length) return;

    const query = $input.val().trim();

    if (query.length < minLength) {
      clearTimeout(debounceTimeout);
      $target.empty().append(
        $("<div>", {
          class: "dropdown-item p-3 text-body-secondary text-center",
          text: "Type at least " + minLength + " characters...",
        }),
      );
      $target.removeAttr("hidden");
      $input.attr("aria-expanded", "true");
      return;
    }

    $target.empty().append(
      $("<div>", {
        class: "dropdown-item p-3 text-body-secondary text-center",
      })
        .append(
          $("<span>", {
            class: "spinner-border spinner-border-sm me-2",
            role: "status",
            "aria-hidden": "true",
          }),
        )
        .append("Searching..."),
    );
    $target.removeAttr("hidden");
    $input.attr("aria-expanded", "true");

    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(function () {
      const data = {};
      data[searchParam] = query;

      $.ajax({
        url: url,
        method: "GET",
        data: data,
        dataType: "json",
        success: function (response) {
          $target.empty();

          let items = [];
          if (response && response.success) {
            if (response.books && response.books.length > 0) {
              items = response.books.map(function (b) {
                return { label: b.title, desc: b.author, available: (b.available  + (b.available != 1 ? ' books' : ' book')) };
              });
            } else if (response.member && response.member.length > 0) {
              items = response.member.map(function (m) {
                return { label: m.name, desc: m.email, available: 'Member' };
              });
            }
          }

          if (items.length > 0) {
            items.forEach(function (item) {

              const $btn = $("<button>", {
                type: "button",
                class: `dropdown-item p-3 border-bottom position-relative ${item.available <= 0 ? "disabled" : ""}`,
                "data-autocomplete-option": item.label,
                "data-label": item.label,
                disabled: item.available <= 0
              });

              const $titleDiv = $("<div>", {
                class: "fw-semibold text-capitalize",
                text: item.label,
              });

              const $descSmall = $("<small>", {
                class: "text-body-secondary",
                text: item.desc,
              });

              const $badgeSpan = $("<span>", {
                class: "position-absolute top-0 end-0 mt-2 badge bg-success me-2",
                text: item.available,
              });

              $btn.append($badgeSpan).append($titleDiv).append($descSmall);
              $target.append($btn);
            });
          } else {
            $target.append(
              $("<div>", {
                class: "dropdown-item p-3 text-body-secondary text-center",
                text: "No results found",
              }),
            );
          }
        },
        error: function () {
          $target.empty().append(
            $("<div>", {
              class: "dropdown-item p-3 text-danger text-center",
              text: "Error loading results",
            }),
          );
        },
      });
    }, 250);
  });

  $(document).on(
    "click",
    "[role='listbox'] button[data-autocomplete-option]",
    function (e) {
      e.preventDefault();
      const $btn = $(this);
      const val = $btn.attr("data-autocomplete-option");

      const $target = $btn.closest("[role='listbox']");
      const targetId = $target.attr("id");
      const $input = $("input[data-autocomplete-target='" + targetId + "']");

      if ($input.length) {
        $input.val(val);
        clearAndHideAutocomplete($input, $target);
      }
    },
  );

  $(document).on("click", function (e) {
    if (
      !$(e.target).closest("input[data-autocomplete-url], [role='listbox']")
        .length
    ) {
      $("input[data-autocomplete-url]").each(function () {
        const $input = $(this);
        const targetId = $input.attr("data-autocomplete-target");
        const $target = $("#" + targetId);
        if ($target.length) {
          clearAndHideAutocomplete($input, $target);
        }
      });
    }
  });

  function clearAndHideAutocomplete($input, $target) {
    $target.attr("hidden", true);
    $input.attr("aria-expanded", "false");
  }
});
