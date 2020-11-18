<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SignUp</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <form method="post" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control p_input">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control p_input">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Register</button>
                </div>

                <p class="sign-up text-center">Already have an Account?<a href="{{ route('login') }}"> Sign In</a></p>
            </form>
        </div>
    </body>
</html>
