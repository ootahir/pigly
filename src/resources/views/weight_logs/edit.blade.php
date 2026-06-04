<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>記録を更新 | PiGLy</title>
    <link rel="stylesheet" href="{{ asset('css/weight_update.css') }}">
</head>
<body>
    <header class="site-header">
        <h1 class="logo">PiGLy</h1>
        <div class="header-actions">
            <a class="action-btn" href="{{ route('weight_logs.target.edit') }}" aria-label="目標体重設定">
                <span>⚙</span>
                <span>目標体重設定</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="action-btn" aria-label="ログアウト">
                    <span>⇥</span>
                    <span>ログアウト</span>
                </button>
            </form>
        </div>
    </header>

    <main class="page-body">
        <section class="update-card">
            <h2 class="page-title">Weight Log</h2>

            <form id="update-form" method="POST" action="{{ route('weight_logs.update', ['weightLog' => $weightLog->id]) }}" class="update-form" novalidate>
                @csrf
                @method('PUT')

                <label for="date" class="field-label">日付</label>
                <input id="date" type="date" name="date" value="{{ old('date', \Carbon\Carbon::parse($weightLog->date)->format('Y-m-d')) }}" required>
                @error('date')
                    <p class="error">{{ $message }}</p>
                @enderror

                <label for="weight" class="field-label">体重</label>
                <div class="field-wrap">
                    <input id="weight" type="number" step="0.1" min="1" max="999.9" name="weight" value="{{ old('weight', $weightLog->weight) }}" required>
                    <span class="unit">kg</span>
                </div>
                @error('weight')
                    <p class="error">{{ $message }}</p>
                @enderror

                <label for="calories" class="field-label">摂取カロリー</label>
                <div class="field-wrap">
                    <input id="calories" type="number" min="0" max="99999" name="calories" value="{{ old('calories', $weightLog->calories) }}">
                    <span class="unit">cal</span>
                </div>
                @error('calories')
                    <p class="error">{{ $message }}</p>
                @enderror

                <label for="exercise_time" class="field-label">運動時間</label>
                <input id="exercise_time" type="time" name="exercise_time" value="{{ old('exercise_time', $weightLog->exercise_time ? \Carbon\Carbon::parse($weightLog->exercise_time)->format('H:i') : null) }}">
                @error('exercise_time')
                    <p class="error">{{ $message }}</p>
                @enderror

                <label for="exercise_content" class="field-label">運動内容</label>
                <textarea id="exercise_content" name="exercise_content" rows="4" placeholder="運動内容を追加">{{ old('exercise_content', $weightLog->exercise_content) }}</textarea>
                @error('exercise_content')
                    <p class="error">{{ $message }}</p>
                @enderror

            </form>

            <div class="actions-row">
                <a class="back-btn" href="{{ route('weight_logs.index') }}">戻る</a>
                <button type="submit" class="update-btn" form="update-form">更新</button>
                <form method="POST" action="{{ route('weight_logs.delete', ['weightLog' => $weightLog->id]) }}" class="delete-form" onsubmit="return confirm('この記録を削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="trash-btn" aria-label="削除">🗑</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
