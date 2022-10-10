<?php

namespace Laravel\Fortify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Events\Verified;
use App\Models\User;

class VerifyEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        // return \dd($this);

        $user = User::find($this->route('id'));

        if (!hash_equals((string) $this->route('hash'), sha1($user->getEmailForVerification()))) {
            return false;
        }
    
        if ($user->markEmailAsVerified())
            event(new Verified($user));
    
        // return redirect($this->redirectPath())->with('verified', true);

        // if (! hash_equals((string) $this->route('id'), (string) $this->user()->getKey())) {
        //     return false;
        // }

        // if (! hash_equals((string) $this->route('hash'), sha1($this->user()->getEmailForVerification()))) {
        //     return false;
        // }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
