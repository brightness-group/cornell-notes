<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->type && $this->type == 'verifyPassword') {
            return [
                'current_password' => 'current_password:web',
            ];
        } else {
            return [
                'current_password' => 'current_password:web',
                'password' => 'required',
                'confirm_password' => 'same:password',
            ];
        }
    }
}
