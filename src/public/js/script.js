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

$(document).on("click", "#confirmModalCancel", function () {
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
