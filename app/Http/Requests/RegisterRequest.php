<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
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
            'nim'                 => 'required|unique:users',
            'username'            => 'required||unique:users',
            'nama_lengkap'        => 'required',
            'password'            => 'required',
            'konfirmasi_password' => 'required|same:password|min:5',
        ];     
    }

    public function messages()
    {
        return [
            'nim.required'             => 'nim wajib di isi',
            'nim.unique'               => 'maaf nim sudah terdaftar',
            'username.required'        => 'username wajib di isi',
            'username.unique'          => 'maaf username sudah terdaftar',
            'konfirmasi_password.same' => 'Konfirmasi password harus sama',
            'konfirmasi_password.min'  => 'Password Minimal 5 Karakter'
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
