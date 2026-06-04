<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>目標体重設定 | PiGLy</title>
    <link rel="stylesheet" href="{{ asset('css/weight_form.css') }}">
</head>
<body>
    <main class="weight-form-page">
        <section class="weight-form-card">
            <h1 class="logo">PiGLy</h1>
            <h2 class="title">目標体重設定</h2>

            <form method="POST" action="{{ route('weight_logs.target.update') }}" class="weight-form">
                @csrf
                @method('PUT')

                <label for="target_weight" class="field-label">目標体重</label>
                <div class="field-wrap">
                    <input
                        id="target_weight"
                        type="number"
                        step="0.1"
                        min="1"
                        max="999.9"
                        name="target_weight"
                        value="{{ old('target_weight', $targetWeight) }}"
                        placeholder="目標体重を入力"
                        required
                    >
                    <span class="unit">kg</span>
                </div>
                @error('target_weight')
                    <p class="error">{{ $message }}</p>
                @enderror

                <div class="actions">
                    <a class="secondary-btn" href="{{ route('weight_logs.index') }}">戻る</a>
                    <button type="submit" class="primary-btn">更新</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
