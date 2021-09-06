You're logged in!<br>
<form method="POST" action="{{ route('logout') }}">
    @csrf

    <input id="logout_button" type="submit" class="btn btn-main btn-effect nomargin"
    value="Logout"/>
</form>

