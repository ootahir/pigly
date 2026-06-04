<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\RegisterStep1Request;
use App\Http\Requests\RegisterStep2Request;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showStep1()
    {
        return view('register.step1');
    }

    public function storeStep1(RegisterStep1Request $request): RedirectResponse
    {
        $validated = $request->validated();

        $request->session()->put('register.step1', [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return redirect()->route('register.step2');
    }

    public function showStep2(Request $request)
    {
        if (! $request->session()->has('register.step1')) {
            return redirect()->route('register.step1');
        }

        return view('register.step2');
    }

    public function storeStep2(RegisterStep2Request $request, CreateNewUser $createNewUser): RedirectResponse
    {
        $step1 = $request->session()->get('register.step1');

        if (! $step1) {
            return redirect()->route('register.step1');
        }

        $validated = $request->validated();

        $user = $createNewUser->create([
            'name' => $step1['name'],
            'email' => $step1['email'],
            'password' => $step1['password'],
            'password_confirmation' => $step1['password_confirmation'] ?? $step1['password'],
        ]);

        WeightTarget::create([
            'user_id' => $user->id,
            'target_weight' => $validated['target_weight'],
        ]);

        WeightLog::create([
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'weight' => $validated['current_weight'],
            'calories' => null,
            'exercise_time' => null,
            'exercise_content' => null,
        ]);

        $request->session()->forget('register.step1');

        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login');
    }
}
