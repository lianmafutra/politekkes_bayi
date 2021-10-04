<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class PertumbuhanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'jenis_kelamin'    => ['required', Rule::in(['L','P'])],
            'usia_dalam_bulan' => 'required|numeric|',
            'berat_badan'      => 'required',
        ];   
    }

    public function messages()
    {
        return [
            'jenis_kelamin.required' => 'jenis_kelamin wajib di isi',
            'jenis_kelamin.in'       => 'Format jenis_kelamin tidak sesuai',
            'berat_badan.required'   => 'berat_badan wajib di isi',
            
        ];
    }

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' =>  $validator->errors()->first(),
            ], 422)); 
      }
}
