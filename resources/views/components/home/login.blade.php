<div class="signin-wrapper">
    <div class="small-dialog-headline">
        <h4 class="text-center">Login</h4>
    </div>

    <div class="small-dialog-content">

        <!-- Start of Login form -->

        <form id="login_form">

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Your Email *"  required />
                <p id="login_error_email" class="error"></p>
            </div>

            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Your Password *" required />
            </div>


            <div class="form-group">
                <div class="checkbox pad-bottom-10">
                    <input id="remember_me" type="checkbox" name="remember" value="yes">
                    <label for="remember_me">Remember me</label>
                </div>
            </div>

            {{--<div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>--}}

            <div class="form-group">
                <input type="submit" value="Sign in" class="btn btn-main btn-effect nomargin" />
            </div>
        </form>
        <!-- End of Login form -->

        <div class="bottom-links">
                    <span>
                        Not a member?
                        <a  class="signUpClick">Sign up</a>
                    </span>
            <a  class="forgetPasswordClick pull-right">Forgot Password</a>
        </div>
    </div>

</div>
