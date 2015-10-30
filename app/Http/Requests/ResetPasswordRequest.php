<?php
/**
 *
 * Description: This class is a request validation
 * Jesus Arriaga - jarriagabarron@gmail.com
 */

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ResetPasswordRequest extends Request
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
            'password'            =>      'required|between:6,40',
            'retype_password'     =>      'required|same:password',
            'code'                =>      'required',
        ];
    }

    public function messages()
    {
        return  [
            'required'      =>      'El :attribute es requerido',
            'between'       =>      'El password debe tener :min o mas caracteres',
            'same'          =>      'Los passwords no coinciden',
        ];
    }
}
