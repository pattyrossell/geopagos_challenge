<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TournamentIndexRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        
        return [
            'gender' => 'nullable|in:f,m',
            'date' => 'nullable|date_format:Y-m-d'
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
            'gender.in' => 'Gender must be f or m',
            'date.data_format' => "The date doesn't match the format Y-m-d."
        ];
    }
}