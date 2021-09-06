@extends('web.layouts.master')
@section('content')
    <main class="login-register-page" style="background-image: url({{ url("css/images/posters/movie-collection.jpg") }})">
        <div class="container">
            <div class="small-dialog login-register" >
                <div class="signin-wrapper">
                    <div class="small-dialog-headline">
                        <h4 class="text-center">Reset Password</h4>
                    </div>

                    <div class="small-dialog-content">
                        <form id="reset_password_form" method="post" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Your Email *" value="{{ old('email',$request->email) }}" required />
                                @if($errors->has('email'))
                                    <p class="error">{{$errors->first('email')}}</p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password">New Password *</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Your New Password *" required />
                                @if($errors->has('password'))
                                    <p class="error">{{$errors->first('password')}}</p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password *</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Insert Your New Password Again *" required />
                            </div>

                            <div class="form-group">
                                <input type="submit" value="Reset password!" class="btn btn-main btn-effect nomargin" />
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </main>

@stop
