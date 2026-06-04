<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規会員登録 | PiGLy</title>
    <link rel="stylesheet" href="{{ asset('css/step2.css') }}">
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 class="logo">PiGLy</h1>
            <h2 class="title">新規会員登録</h2>
            <p class="step-label">STEP2 体重データの入力</p>

            <form method="POST" action="{{ route('register.step2.store') }}" novalidate>
                @csrf

                <div class="form-group">
                    <label for="current_weight">現在の体重</label>
                    <div class="weight-field">
                        <input
                            type="number"
                            id="current_weight"
                            name="current_weight"
                            placeholder="現在の体重を入力"
                            value="{{ old('current_weight') }}"
                            step="0.1"
                            min="1"
                            max="9999.9"
                            required
                        >
                        <span class="unit">kg</span>
                    </div>
                    @foreach ($errors->get('current_weight') as $message)
                        <span class="error">{{ $message }}</span>
                    @endforeach
                </div>

                <div class="form-group">
                    <label for="target_weight">目標の体重</label>
                    <div class="weight-field">
                        <input
                            type="number"
                            id="target_weight"
                            name="target_weight"
                            placeholder="目標の体重を入力"
                            value="{{ old('target_weight') }}"
                            step="0.1"
                            min="1"
                            max="9999.9"
                            required
                        >
                        <span class="unit">kg</span>
                    </div>
                    @foreach ($errors->get('target_weight') as $message)
                        <span class="error">{{ $message }}</span>
                    @endforeach
                </div>

                <div class="form-action">
                    <button type="submit" class="btn-submit">アカウント作成</button>
                </div>
            </form>

            <div class="back-link">
                <a href="{{ route('register.step1') }}">戻る</a>
            </div>
        </div>
    </div>
</body>
</html>
