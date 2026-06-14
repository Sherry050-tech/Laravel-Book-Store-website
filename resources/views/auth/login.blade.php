<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BookStore</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f3f4f6; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .login-card { background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 400px; width: 100%; }
        .logo { text-align: center; font-size: 24px; font-weight: 700; color: #111; margin-bottom: 24px; text-decoration: none; display: block; }
        .logo span { color: #e8c97e; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; font-weight: 500; margin-bottom: 6px; color: #374151; }
        .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; box-sizing: border-box; outline: none; }
        .form-control:focus { border-color: #e8c97e; }
        .btn-login { width: 100%; padding: 12px; background: #111; color: #fff; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; margin-top: 10px; transition: background 0.2s; }
        .btn-login:hover { background: #333; }
        .error-list { background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; font-size: 14px; margin-bottom: 20px; }
        .error-list ul { margin: 0; padding-left: 20px; }
    </style>
</head>
<body>
    <div class="login-card">
        <a href="/" class="logo">📚 Book<span>Store</span></a>

        @if ($errors->any())
            <div class="error-list">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required autocomplete="current-password">
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; font-size: 14px;">
                <label><input type="checkbox" name="remember"> Remember me</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color: #888; text-decoration: none;">Forgot password?</a>
                @endif
            </div>
            <button type="submit" class="btn-login">Log In</button>
        </form>
    </div>
</body>
</html>
