<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Requests\WeightLogRequest;
use App\Http\Requests\UpdateWeightLogRequest;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WeightLogController extends Controller
{
    public function index(Request $request): View
    {
        return view('weight_logs.index', $this->buildIndexViewData($request, false));
    }

    public function editTarget(Request $request): View
    {
        $targetWeight = WeightTarget::query()
            ->where('user_id', $request->user()->id)
            ->value('target_weight');

        return view('weight_logs.target', [
            'targetWeight' => $targetWeight,
        ]);
    }

    public function updateTarget(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'target_weight' => ['required', 'numeric', 'between:1,999.9'],
        ], [
            'target_weight.required' => '目標体重を入力してください。',
            'target_weight.numeric' => '目標体重は数値で入力してください。',
            'target_weight.between' => '目標体重は1.0〜999.9の範囲で入力してください。',
        ]);

        WeightTarget::query()->updateOrCreate(
            ['user_id' => $request->user()->id],
            ['target_weight' => $validated['target_weight']]
        );

        return redirect()->route('weight_logs.index');
    }

    public function search(Request $request): View
    {
        return view('weight_logs.search', $this->buildIndexViewData($request, false));
    }

    public function create(Request $request): View
    {
        return view('weight_logs.index', $this->buildIndexViewData($request, true));
    }

    public function store(WeightLogRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        WeightLog::query()->create([
            'user_id' => $request->user()->id,
            'date' => $validated['date'],
            'weight' => $validated['weight'],
            'calories' => $validated['calories'] ?? null,
            'exercise_time' => isset($validated['exercise_time'])
                ? $this->normalizeExerciseTime($validated['exercise_time'])
                : null,
            'exercise_content' => $validated['exercise_content'] ?? null,
        ]);

        return redirect()->route('weight_logs.index');
    }

    public function show(Request $request, WeightLog $weightLog): View
    {
        abort_unless((int) $weightLog->user_id === (int) $request->user()->id, 403);

        return view('weight_logs.edit', [
            'weightLog' => $weightLog,
        ]);
    }

    public function update(UpdateWeightLogRequest $request, WeightLog $weightLog): RedirectResponse
    {
        abort_unless((int) $weightLog->user_id === (int) $request->user()->id, 403);
        $validated = $request->validated();

        $weightLog->update([
            'date' => $validated['date'],
            'weight' => $validated['weight'],
            'calories' => $validated['calories'] ?? null,
            'exercise_time' => isset($validated['exercise_time'])
                ? $this->normalizeExerciseTime($validated['exercise_time'])
                : null,
            'exercise_content' => $validated['exercise_content'] ?? null,
        ]);

        return redirect()->route('weight_logs.index');
    }

    public function destroy(Request $request, WeightLog $weightLog): RedirectResponse
    {
        abort_unless((int) $weightLog->user_id === (int) $request->user()->id, 403);

        $weightLog->delete();

        return redirect()->route('weight_logs.index');
    }

    private function buildIndexViewData(Request $request, bool $showCreateModal): array
    {
        $userId = $request->user()->id;
        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ], [
            'start_date.date' => '開始日は日付を選択してください。',
            'end_date.date' => '終了日は日付を選択してください。',
            'end_date.after_or_equal' => '終了日は開始日以降の日付を選択してください。',
        ]);

        $startDate = $validated['start_date'] ?? null;
        $endDate = $validated['end_date'] ?? null;
        $isSearching = $startDate !== null || $endDate !== null;

        $logsQuery = WeightLog::query()
            ->where('user_id', $userId)
            ->orderByDesc('date')
            ->orderByDesc('id');

        if ($startDate !== null) {
            $logsQuery->whereDate('date', '>=', $startDate);
        }

        if ($endDate !== null) {
            $logsQuery->whereDate('date', '<=', $endDate);
        }

        $logs = $logsQuery->paginate(8)->withQueryString();

        $latestWeight = WeightLog::query()
            ->where('user_id', $userId)
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->value('weight');

        $targetWeight = WeightTarget::query()
            ->where('user_id', $userId)
            ->orderByDesc('id')
            ->value('target_weight');

        $diffToTarget = null;
        if ($targetWeight !== null && $latestWeight !== null) {
            $diffToTarget = (float) $latestWeight - (float) $targetWeight;
        }

        return [
            'logs' => $logs,
            'targetWeight' => $targetWeight,
            'latestWeight' => $latestWeight,
            'diffToTarget' => $diffToTarget,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'isSearching' => $isSearching,
            'showCreateModal' => $showCreateModal,
        ];
    }

    private function normalizeExerciseTime(string $exerciseTime): string
    {
        $format = strlen($exerciseTime) === 5 ? 'H:i' : 'H:i:s';

        return Carbon::createFromFormat($format, $exerciseTime)->format('H:i:s');
    }

}