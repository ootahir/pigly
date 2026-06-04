<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規会員登録 | PiGLy</title>
    <link rel="stylesheet" href="{{ asset('css/step1.css') }}">
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 class="logo">PiGLy</h1>
            <h2 class="title">新規会員登録</h2>
            <p class="step-label">STEP1 アカウント情報の登録</p>

            <form method="POST" action="{{ route('register.step1.store') }}" novalidate>
                @csrf

                <div class="form-group">
                    <label for="name">お名前</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="名前を入力"
                        value="{{ old('name') }}"
                        maxlength="255"
                        required
                        autofocus
                    >
                    @foreach ($errors->get('name') as $message)
                        <span class="error">{{ $message }}</span>
                    @endforeach
                </div>

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="メールアドレスを入力"
                        value="{{ old('email') }}"
                        maxlength="255"
                        required
                    >
                    @foreach ($errors->get('email') as $message)
                        <span class="error">{{ $message }}</span>
                    @endforeach
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="パスワードを入力"
                        required
                    >
                    @foreach ($errors->get('password') as $message)
                        <span class="error">{{ $message }}</span>
                    @endforeach
                </div>

                <div class="form-action">
                    <button type="submit" class="btn-submit">次に進む</button>
                </div>
            </form>

            <div class="login-link">
                <a href="{{ route('login') }}">ログインはこちら</a>
            </div>
        </div>
    </div>

</body>
</html>
