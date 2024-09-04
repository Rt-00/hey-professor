<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Rules\EndWithQuestionMarkRule;
use Closure;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {
        $attributes = request()->validate([
            'question' => [
                'required',
                'min:10',
                // using clojure to validate
                // function (string $attribute, mixed $value, Closure $fail) {
                //     if ($value[-1] != '?') {
                //         $fail('Are you sure that is a question? It is missing the question mark in the end.');
                //     }
                // },
                // using Custom Rule
                new EndWithQuestionMarkRule,
            ],
        ]);

        Question::query()->create($attributes);

        return to_route('dashboard');
    }
}
