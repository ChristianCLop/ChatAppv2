document.addEventListener("DOMContentLoaded", function () {
    const passwordConfField = document.querySelector(".form input[name='passwordConf']"),
          toggleConfIcon = document.querySelector("#toggleConfIcon");
  
    toggleConfIcon.addEventListener("click", () => {
      if (passwordConfField.type === "password") {
        passwordConfField.type = "text";
        toggleConfIcon.classList.add("active");
      } else {
        passwordConfField.type = "password";
        toggleConfIcon.classList.remove("active");
      }
    });
  });
  