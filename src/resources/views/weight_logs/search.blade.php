<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>検索結果 | PiGLy</title>
	<link rel="stylesheet" href="{{ asset('css/search.css') }}">
</head>
<body>
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
					<input class="date-input" type="date" name="start_date" value="{{ $startDate }}" aria-label="開始日">
					<span class="range-separator">〜</span>
					<input class="date-input" type="date" name="end_date" value="{{ $endDate }}" aria-label="終了日">
					<button type="submit" class="search-btn">検索</button>
					<a class="reset-btn" href="{{ route('weight_logs.index') }}">リセット</a>
				</form>
				<a class="add-btn" href="{{ route('weight_logs.create') }}">データ追加</a>
			</div>

			@if ($errors->has('start_date') || $errors->has('end_date'))
				<p class="search-error">{{ $errors->first() }}</p>
			@endif

			<p class="search-result-label">
				{{ $startDate ? \Carbon\Carbon::parse($startDate)->format('Y年n月j日') : '指定なし' }}〜{{ $endDate ? \Carbon\Carbon::parse($endDate)->format('Y年n月j日') : '指定なし' }}の検索結果　{{ $logs->total() }}件
			</p>

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
							<td>{{ $log->calories !== null ? $log->calories . 'cal' : '-' }}</td>
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
</body>
</html>
