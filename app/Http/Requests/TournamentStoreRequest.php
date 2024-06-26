<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\PowerOfTwo;

class TournamentStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'gender' => 'required|in:f,m',
            'amountPlayers' => ['nullable', 'integer', new PowerOfTwo]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message'   => 'Validation errors',
            'error'      => $validator->errors()
        ], 400));
    }

    public function messages()
    {
        return [
            'gender.required' => 'Gender is required',
            'gender.in' => 'Gender must be f or m'
        ];
    }
}
