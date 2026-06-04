<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>体重管理 | PiGLy</title>
	<link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body class="{{ !empty($showCreateModal) ? 'modal-open' : '' }}">
	<header class="site-header">
		<h1 class="logo">PiGLy</h1>
		<div class="header-actions">
			<a class="action-btn" href="{{ route('weight_logs.target.edit') }}" aria-label="目標体重設定">
				<span class="icon">⚙</span>
				<span>目標体重設定</span>
			</a>
			<form method="POST" action="{{ route('logout') }}">
				@csrf
				<button type="submit" class="action-btn" aria-label="ログアウト">
					<span class="icon">⇥</span>
					<span>ログアウト</span>
				</button>
			</form>
		</div>
	</header>

	<main class="dashboard">
		<section class="summary-card">
			<div class="summary-item">
				<p class="summary-label">目標体重</p>
				<p class="summary-value">
					{{ $targetWeight !== null ? number_format((float) $targetWeight, 1) : '-' }}
					<span class="summary-unit">kg</span>
				</p>
			</div>
			<div class="summary-item">
				<p class="summary-label">目標まで</p>
				<p class="summary-value">
					{{ $diffToTarget !== null ? number_format($diffToTarget, 1) : '-' }}
					<span class="summary-unit">kg</span>
				</p>
			</div>
			<div class="summary-item">
				<p class="summary-label">最新体重</p>
				<p class="summary-value">
					{{ $latestWeight !== null ? number_format((float) $latestWeight, 1) : '-' }}
					<span class="summary-unit">kg</span>
				</p>
			</div>
		</section>

		<section class="table-card">
			<div class="toolbar">
				<form class="search-form" method="GET" action="{{ route('weight_logs.search') }}">
					<input type="date" name="start_date" value="{{ $startDate }}" aria-label="開始日">
					<span class="range-separator">〜</span>
					<input type="date" name="end_date" value="{{ $endDate }}" aria-label="終了日">
					<button type="submit" class="search-btn">検索</button>
					@if ($isSearching)
						<a class="reset-btn" href="{{ route('weight_logs.index') }}">リセット</a>
					@endif
				</form>
				<a class="add-btn" href="{{ route('weight_logs.create') }}">データを追加</a>
			</div>

			@if ($errors->has('start_date') || $errors->has('end_date'))
				<p class="search-error">{{ $errors->first() }}</p>
			@endif

			@if ($isSearching)
				<p class="search-result-label">
					{{ $startDate ? \Carbon\Carbon::parse($startDate)->format('Y/m/d') : '指定なし' }}〜{{ $endDate ? \Carbon\Carbon::parse($endDate)->format('Y/m/d') : '指定なし' }}の検索結果 {{ $logs->total() }}件
				</p>
			@endif

			<table class="log-table">
				<thead>
					<tr>
						<th>日付</th>
						<th>体重</th>
						<th>食事摂取カロリー</th>
						<th>運動時間</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@forelse ($logs as $log)
						<tr>
							<td>{{ \Carbon\Carbon::parse($log->date)->format('Y/m/d') }}</td>
							<td>{{ number_format((float) $log->weight, 1) }}kg</td>
							<td>{{ $log->calories !== null ? $log->calories . 'col' : '-' }}</td>
							<td>{{ $log->exercise_time !== null ? \Carbon\Carbon::parse($log->exercise_time)->format('H:i') : '-' }}</td>
							<td class="edit-col">
								<a class="edit-link" href="{{ route('weight_logs.show', ['weightLog' => $log->id]) }}" aria-label="編集">
									<span class="pencil-icon" aria-hidden="true"></span>
								</a>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="5" class="empty">データがありません</td>
						</tr>
					@endforelse
				</tbody>
			</table>

			@if ($logs->hasPages())
				<nav class="pager" aria-label="ページ送り">
					@if ($logs->onFirstPage())
						<span class="pager-arrow disabled">&lt;</span>
					@else
						<a class="pager-arrow" href="{{ $logs->previousPageUrl() }}">&lt;</a>
					@endif

					@foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
						@if ($page === $logs->currentPage())
							<span class="page-link current">{{ $page }}</span>
						@else
							<a class="page-link" href="{{ $url }}">{{ $page }}</a>
						@endif
					@endforeach

					@if ($logs->hasMorePages())
						<a class="pager-arrow" href="{{ $logs->nextPageUrl() }}">&gt;</a>
					@else
						<span class="pager-arrow disabled">&gt;</span>
					@endif
				</nav>
			@endif
		</section>
	</main>

	@if (!empty($showCreateModal))
		<div class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="weight-log-modal-title">
			<section class="create-modal" aria-describedby="weight-log-modal-description">
				<h2 id="weight-log-modal-title" class="modal-title">Weight Logを追加</h2>
				<p id="weight-log-modal-description" class="sr-only">体重の記録を登録します。</p>

				<form method="POST" action="{{ route('weight_logs.store') }}" class="create-form" novalidate autocomplete="off">
					@csrf

					<div class="modal-field">
						<label for="date" class="modal-label">日付 <span class="required-badge">必須</span></label>
						<input id="date" type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" required autocomplete="off">
						@error('date')
							<p class="field-error">{{ $message }}</p>
						@enderror
					</div>

					<div class="modal-field">
						<label for="weight" class="modal-label">体重 <span class="required-badge">必須</span></label>
						<div class="input-wrap">
							<input id="weight" type="number" step="0.1" min="1" max="999.9" name="weight" value="{{ old('weight', '') }}" placeholder="50.0" required autocomplete="off">
							<span class="input-unit">kg</span>
						</div>
						@error('weight')
							<p class="field-error">{{ $message }}</p>
						@enderror
					</div>

					<div class="modal-field">
						<label for="calories" class="modal-label">摂取カロリー <span class="required-badge">必須</span></label>
						<div class="input-wrap">
							<input id="calories" type="number" min="0" max="99999" name="calories" value="{{ old('calories', '') }}" placeholder="1200" required autocomplete="off">
							<span class="input-unit">cal</span>
						</div>
						@error('calories')
							<p class="field-error">{{ $message }}</p>
						@enderror
					</div>

					<div class="modal-field">
						<label for="exercise_time" class="modal-label">運動時間 <span class="required-badge">必須</span></label>
						<input id="exercise_time" type="time" name="exercise_time" value="{{ old('exercise_time', '') }}" required autocomplete="off">
						@error('exercise_time')
							<p class="field-error">{{ $message }}</p>
						@enderror
					</div>

					<div class="modal-field">
						<label for="exercise_content" class="modal-label">運動内容</label>
						<textarea id="exercise_content" name="exercise_content" rows="4" placeholder="運動内容を追加" required autocomplete="off">{{ old('exercise_content', '') }}</textarea>
						@error('exercise_content')
							<p class="field-error">{{ $message }}</p>
						@enderror
					</div>

					<div class="modal-actions">
						<a class="modal-back-btn" href="{{ route('weight_logs.index') }}">戻る</a>
						<button type="submit" class="modal-submit-btn">登録</button>
					</div>
				</form>
			</section>
		</div>
	@endif
</body>
</html>
