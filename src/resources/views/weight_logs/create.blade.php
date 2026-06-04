<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>体重を記録 | PiGLy</title>
    <link rel="stylesheet" href="{{ asset('css/weight_form.css') }}">
</head>
<body>
    <main class="weight-form-page">
        <section class="weight-form-card wide">
            <h1 class="logo">PiGLy</h1>
            <h2 class="title">体重を記録</h2>

            <form method="POST" action="{{ route('weight_logs.store') }}" class="weight-form" novalidate autocomplete="off">
                @csrf

                <label for="date" class="field-label">日付</label>
                <input id="date" type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" required autocomplete="off">
                @error('date')
                    <p class="error">{{ $message }}</p>
                @enderror

                <label for="weight" class="field-label">体重</label>
                <div class="field-wrap">
                    <input id="weight" type="number" step="0.1" min="1" max="999.9" name="weight" value="{{ old('weight', '') }}" required autocomplete="off">
                    <span class="unit">kg</span>
                </div>
                @error('weight')
                    <p class="error">{{ $message }}</p>
                @enderror

                <label for="calories" class="field-label">摂取カロリー</label>
                <div class="field-wrap">
                    <input id="calories" type="number" min="0" max="99999" name="calories" value="{{ old('calories', '') }}" required autocomplete="off">
                    <span class="unit">col</span>
                </div>
                @error('calories')
                    <p class="error">{{ $message }}</p>
                @enderror

                <label for="exercise_time" class="field-label">運動時間</label>
                <input id="exercise_time" type="time" name="exercise_time" value="{{ old('exercise_time', '') }}" required autocomplete="off">
                @error('exercise_time')
                    <p class="error">{{ $message }}</p>
                @enderror

                <label for="exercise_content" class="field-label">運動内容</label>
                <textarea id="exercise_content" name="exercise_content" rows="3" placeholder="運動内容を入力" required autocomplete="off">{{ old('exercise_content', '') }}</textarea>
                @error('exercise_content')
                    <p class="error">{{ $message }}</p>
                @enderror

                <div class="actions">
                    <a class="secondary-btn" href="{{ route('weight_logs.index') }}">戻る</a>
                    <button type="submit" class="primary-btn">保存</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
