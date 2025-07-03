document.addEventListener("DOMContentLoaded", function () {
  const emailInput = document.getElementById("email");
  const passwordInput = document.getElementById("password");

  // Email
  emailInput.addEventListener("invalid", function () {
    if (emailInput.value === "") {
      emailInput.setCustomValidity("Email wajib diisi!");
    } else {
      emailInput.setCustomValidity("Format email tidak valid. Gunakan tanda @.");
    }
  });

  emailInput.addEventListener("input", function () {
    emailInput.setCustomValidity("");
  });

  // Password
  passwordInput.addEventListener("invalid", function () {
    if (passwordInput.value === "") {
      passwordInput.setCustomValidity("Password wajib diisi!");
    } else {
      passwordInput.setCustomValidity("");
    }
  });

  passwordInput.addEventListener("input", function () {
    passwordInput.setCustomValidity("");
  });
});
