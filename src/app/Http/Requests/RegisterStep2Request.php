<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStep2Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'current_weight' => $this->weightRules(),
            'target_weight' => $this->weightRules(),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    private function weightRules(): array
    {
        return [
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
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'current_weight.required' => '体重を入力してください',
            'current_weight.numeric' => '数字で入力してください',
            'target_weight.required' => '体重を入力してください',
            'target_weight.numeric' => '数字で入力してください',
        ];
    }
}