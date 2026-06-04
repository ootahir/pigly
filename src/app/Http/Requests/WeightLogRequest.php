<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeightLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function getRedirectUrl(): string
    {
        return route('weight_logs.create');
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'weight' => [
                'bail',
                'required',
                'numeric',
                function (string $attribute, $value, \Closure $fail): void {
                    $rawValue = (string) $value;

                    if (! preg_match('/^\d+(?:\.\d+)?$/', $rawValue)) {
                        $fail('数字で入力してください');

                        return;
                    }

                    $parts = explode('.', $rawValue);

                    if (strlen($parts[0]) > 4) {
                        $fail('4桁までの数字で入力してください');

                        return;
                    }

                    if (isset($parts[1]) && strlen($parts[1]) > 1) {
                        $fail('小数点は1桁で入力してください');
                    }
                },
            ],
            'calories' => ['bail', 'required', 'numeric'],
            'exercise_time' => [
                'required',
                function (string $attribute, $value, \Closure $fail): void {
                    $rawValue = (string) $value;

                    if (! preg_match('/^\d{2}:\d{2}(?::\d{2})?$/', $rawValue)) {
                        $fail('運動時間は正しい形式で入力してください');
                    }
                },
            ],
            'exercise_content' => ['required', 'string', 'max:120'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'date.required' => '日付を入力してください',
            'weight.required' => '体重を入力してください',
            'weight.numeric' => '数字で入力してください',
            'calories.required' => '摂取カロリーを入力してください',
            'calories.numeric' => '数字で入力してください',
            'exercise_time.required' => '運動時間を入力してください',
            'exercise_content.required' => '運動内容を入力してください',
            'exercise_content.max' => '120文字以内で入力してください',
        ];
    }
}
