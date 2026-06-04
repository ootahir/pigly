<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ログイン | PiGLy</title>
	<link rel="stylesheet" href="{{ asset('css/login/login.css') }}">
</head>
<body>
	<main class="login-page">
		<section class="login-card">
			<h1 class="logo">PiGLy</h1>
			<p class="subtitle">ログイン</p>

			<form method="POST" action="{{ route('login') }}" class="login-form" novalidate>
				@csrf

				<div class="form-group">
					<label for="email">メールアドレス</label>
					<input
						id="email"
						type="email"
						name="email"
						value="{{ old('email') }}"
						placeholder="メールアドレスを入力"
						required
						autofocus
					>
					@error('email')
						<p class="error">{{ $message }}</p>
					@enderror
				</div>

				<div class="form-group">
					<label for="password">パスワード</label>
					<input
						id="password"
						type="password"
						name="password"
						placeholder="パスワードを入力"
						required
					>
					@error('password')
						<p class="error">{{ $message }}</p>
					@enderror
				</div>

				<button type="submit" class="submit-btn">ログイン</button>
			</form>

			<div class="register-link">
				<a href="{{ route('register.step1') }}">新規会員登録はこちら</a>
			</div>
		</section>
	</main>
</body>
</html>
