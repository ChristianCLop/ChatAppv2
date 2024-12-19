<?php
session_start();
if (isset($_SESSION['unique_id'])) {
  header("location: users.php");
}
?>

<?php include_once "header.php"; ?>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="border rounded-lg bg-white shadow-md w-full max-w-md p-6">
    <section class="form login">
      <header class="text-2xl font-bold text-green-600 text-center mb-6">QuickTalk</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text hidden text-red-500 text-sm mb-2"></div>

        <div class="field input mb-4">
          <label class="block text-gray-700 text-sm font-medium">Teléfono</label>
          <input type="text" name="phone" placeholder="Teléfono" required maxlength="10" minlength="10" 
            oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
            class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <div class="field input mb-4">
          <label class="block text-gray-700 text-sm font-medium">Contraseña</label>
          <div class="relative">
            <input type="password" name="password" id="password" placeholder="Ingrese su contraseña" required
              class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
            <i class="fas fa-eye absolute top-3 right-3 text-gray-500 cursor-pointer"></i>
          </div>
        </div>

        <div class="field button mt-6">
          <input type="submit" name="submit" value="Ingresar"
            class="w-full bg-green-500 text-white py-2 rounded font-medium hover:bg-green-600">
        </div>
      </form>

      <div class="link text-center mt-4 text-sm text-gray-600">
        No tienes cuenta? <a href="index.php" class="text-green-500 hover:underline">Regístrate</a>
      </div>
    </section>
  </div>

  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/login.js"></script>
  <script>
    function validatePassword() {
      var passwordInput = document.getElementById('password');

      // Elimina los espacios en blanco al principio y al final de la cadena
      passwordInput.value = passwordInput.value.trim();

      // Actualiza el valor de los campos en el formulario
      if (passwordInput.value !== passwordInput.value.trim()) {
        passwordInput.setCustomValidity('La contraseña no debe contener espacios en blanco.');
      } else {
        passwordInput.setCustomValidity('');
      }
    }
  </script>
</body>

</html>