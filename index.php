<?php
session_start();
if (isset($_SESSION['unique_id'])) {
  header("location: users.php");
}
?>

<?php include_once "header.php"; ?>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="border rounded-lg bg-white shadow-md w-full max-w-md p-6">
    <section class="form signup">
      <header class="text-2xl font-bold text-green-600 text-center mb-6">QuickTalk</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off" onsubmit="return validatePassword()">
        <div class="error-text hidden text-red-500 text-sm mb-2"></div>

        <div class="name-details grid grid-cols-2 gap-4">
          <div class="field input">
            <label class="block text-gray-700 text-sm font-medium">Nombre</label>
            <input type="text" name="fname" placeholder="Nombre" required maxlength="15" minlength="4"
              class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
          </div>
          <div class="field input">
            <label class="block text-gray-700 text-sm font-medium">Apellido</label>
            <input type="text" name="lname" placeholder="Apellido" required maxlength="15" minlength="4"
              class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
          </div>
        </div>

        <div class="field input mt-4">
          <label class="block text-gray-700 text-sm font-medium">Teléfono</label>
          <input type="text" name="phone" placeholder="Teléfono" required maxlength="10" minlength="10"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <div class="field input mt-4">
          <label class="block text-gray-700 text-sm font-medium">Contraseña</label>
          <input type="password" name="password" id="password" placeholder="Contraseña"
            oninput="validatePassword()" required maxlength="30" minlength="4" pattern="^\S*$"
            class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <div class="field input mt-4">
          <label class="block text-gray-700 text-sm font-medium">Confirmar Contraseña</label>
          <input type="password" name="passwordConf" id="passwordConf" placeholder="Confirmar Contraseña"
            oninput="validatePassword()" required maxlength="30" minlength="4" pattern="^\S*$"
            class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>
        <span id="passwordMatch" class="text-red-500 text-sm mt-2 block"></span>

        <!-- <div class="field select">
          <label>Rol del Usuario</label>
          <select name="rol" required>
            <option value="Secretario">Secretario</option>
            <option value="Bodeguero">Bodeguero</option>
          </select>
        </div> -->

        <div class="field image mt-4">
          <label class="block text-gray-700 text-sm font-medium">Seleccione Imagen de Perfil</label>
          <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required
            class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <div class="field button mt-6">
          <input type="submit" name="submit" value="Ir al Chat" id="submitButton" disabled
            class="w-full bg-green-500 text-white py-2 rounded font-medium hover:bg-green-600 disabled:bg-gray-300 disabled:cursor-not-allowed">
        </div>
      </form>

      <div class="link text-center mt-4 text-sm text-gray-600">
        Ya tienes cuenta? <a href="login.php" class="text-green-500 hover:underline">Inicia Sesión</a>
      </div>
    </section>
  </div>

  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/pass-show-hide-conf.js"></script>
  <script src="javascript/signup.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Llama a la función de validación cuando se carga la página
      validatePassword();

      // Agrega un evento de entrada a los campos de contraseña
      document.getElementById("password").addEventListener("input", validatePassword);
      document.getElementById("passwordConf").addEventListener("input", validatePassword);
    });

    function validatePassword() {
      var password = document.getElementById("password").value;
      var confirmPassword = document.getElementById("passwordConf").value;
      var passwordMatchSpan = document.getElementById("passwordMatch");
      var submitButton = document.getElementById("submitButton");

      // Verifica la longitud y el patrón regex
      if (password.length < 4 || password.length > 30 || !/^\S*$/.test(password)) {
        passwordMatchSpan.innerHTML = "La contraseña debe tener entre 4 y 30 caracteres y no contener espacios.";
        submitButton.disabled = true;
      } else if (password !== confirmPassword) {
        passwordMatchSpan.innerHTML = "Las contraseñas no coinciden.";
        submitButton.disabled = true;
      } else {
        passwordMatchSpan.innerHTML = "";
        submitButton.disabled = false;
      }
    }
  </script>
</body>

</html>