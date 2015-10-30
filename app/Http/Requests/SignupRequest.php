<?php
/**
 *
 * Description: This class is a request validation
 * Jesus Arriaga - jarriagabarron@gmail.com
 */

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SignupRequest extends Request
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
            'email'         =>      'required|email|unique_email',
            'firstname'     =>      'required',
            'password'      =>      'required|between:6,40',
        ];
    }

    public function messages()
    {
        return  [
            'email'         =>      'El email que ingresaste no es correcto ',
            'required'      =>      'El :attribute es requerido',
            'unique_email'  =>      'El email ya esta registrado',
            'between'       =>      'El password debe tener :min o mas caracteres'
        ];
    }
}
