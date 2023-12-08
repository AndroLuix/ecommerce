<?php
components('header');
?>
<title>login</title>
<div class="container">
  <h2 class="text-center mt-4">Login</h2>
  <form class="container-sm p-3 d-grid justify-content-center ">

    <div class="border border-primary rounded p-5">
      <!-- Email input -->
      <div class="form-outline mb-4 ">
        <input type="email" id="form2Example1" class="form-control  " />
        <label class="form-label" for="form2Example1">Email address</label>
      </div>

      <!-- Password input -->
      <div class="form-outline mb-4">
        <input type="password" id="form2Example2" class="form-control" />
        <label class="form-label" for="form2Example2">Password</label>
      </div>

      <!-- 2 column grid layout for inline styling -->
      <div class="row mb-4">
        <div class="col d-flex justify-content-center">
          <!-- Checkbox -->
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
            <label class="form-check-label" for="form2Example31"> Remember me </label>
          </div>
        </div>

        <div class="col">
          <!-- Simple link -->
          <a href="#!">Forgot password?</a>
        </div>
      </div>

      <!-- Submit button -->
      <div class="d-grid gap-2">
        <button class="btn btn-primary m-5" type="button">Sign In</button>
      </div>

      <!-- Register buttons -->
      <div class="text-center">
        <p>Not a member? <a href="/register">Register</a></p>
        <p>or sign up with:</p>
        <button type="button" class="btn btn-link btn-floating mx-1">
          <i class="fab fa-facebook-f"></i>
        </button>

        <button type="button" class="btn btn-link btn-floating mx-1">
          <i class="fab fa-google"></i>
        </button>

        <button type="button" class="btn btn-link btn-floating mx-1">
          <i class="fab fa-twitter"></i>
        </button>

        <button type="button" class="btn btn-link btn-floating conatiner">
          <i class="fab fa-github"></i>
        </button>
      </div>

    </div>
  </form>
</div>


<?php
components('footer');
?>