<?php
components('header');
?>
<title>Register</title>
<div class="container text-center mt-4">
    <div>
        <h2>Register</h2>
        <a href="register-seller"> Register as a seller <a>
                <form class=" d-inline justify-content-center ">

                    <div class="border border-primary rounded p-5 ">

                        <!--  first name input -->
                        <div class="form-outline d-flex flew-row mb-3">
                            <label class="form-label" for="form2Example1"></label>

                            <input name="name" type="text" id="form2Example1" class="form-control m-2" placeholder="First name" />



                            <!--  last name input -->
                            <label class="form-label" for="form2Example1"></label>
                            <input name="lastname" type="text" id="form2Example1" class="form-control m-2" placeholder="Last name" />
                        </div>


                        <!-- Email input -->
                        <div class="form-outline m-2">
                            <label class="form-label" for="form2Example1"></label>
                            <input name="email" type="email" id="form2Example1" class="form-control" placeholder="your@email.example" />
                        </div>

                        <!-- Password input -->
                        <div class="form-outline d-flex flew-row mb-3">

                            <label class="form-label" for="form2Example2"></label>
                            <input type="password" name="password" id="form2Example2" class="form-control m-2" placeholder="password" />

                            <label class="form-label" for="form2Example2"></label>
                            <input type="password" name="repeat_password" id="form2Example2" class="form-control m-2" placeholder="repeat password" />

                        </div>



                        <!-- Submit button -->
                        <div class="d-grid gap-1">
                            <button class="btn btn-primary mt-5 mb-2" type="button">Sign In</button>
                        </div>

                        <!-- Register buttons -->
                        <div class="text-center">
                            <p>You are a member? <a href="/">Login</a></p>
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