<div class="signup-wrapper">
    <div class="small-dialog-headline">
        <h4 class="text-center">Register</h4>
    </div>

    <div class="small-dialog-content">

        <!-- Start of Registration form -->
        <form id="registration_form">

            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Your Name *" value="{{ old('name') }}" required />
                <p id="registration_error_name" class="error"></p>

            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Your Email *" value="{{ old('email') }}" required />
                <p id="registration_error_email" class="error"></p>
            </div>

            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Your Password *" required />
                <p id="registration_error_password" class="error"></p>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password *</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Insert Your Password Again *" required />
                <p id="registration_error_password_confirmation" class="error"></p>
            </div>

            <div class="form-group">
                <input id="registration_button" type="submit" class="btn btn-main btn-effect nomargin"
                       value="Sign up!"/>
            </div>

        </form>

        <!-- End of Registration form -->

        <div class="bottom-links">
                    <span>
                        Already have an account?
                        <a class="signInClick">Sign in</a>
                    </span>

            <a class="forgetPasswordClick pull-right">Forgot Password</a>
        </div>

    </div> <!-- .small-dialog-content -->

</div>


