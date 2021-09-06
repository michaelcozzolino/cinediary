<div class="forgetpassword-wrapper">
    <div class="small-dialog-headline">
        <h4 class="text-center">Forgot Password</h4>
    </div>

    <div class="small-dialog-content">

        <!-- Start of Forger Password form -->
        <form id="forgot_password_form">
            <div class="form-group">
                <label for="password">Email Address *</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Email Address *" required/>
                <p class="error" id="forgot_password_error_email"></p>
            </div>

            <div class="form-group" id="forgot_password_submit_button">
                <input type="submit" name="submit" value="Get New Password" class="btn btn-main btn-effect nomargin" />
            </div>
            <p class="text-success" id="forgot_password_success"></p>
        </form>
        <!-- End of Forger Password form -->

        <div class="bottom-links">
            <a class="cancelClick">Cancel</a>
        </div>

    </div><!-- .small-dialog-content -->

</div>
