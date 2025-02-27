<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:10',
            'email' => ['required', 'email', function ($attribute, $value, $fail) {
                $domain = substr(strrchr($value, "@"), 1);

                // Prevent Gmail emails
                if ($domain === 'gmail.com') {
                    $fail('Gmail addresses are not allowed.');
                    return;
                }

                // Check if the domain has valid MX records
                if (!checkdnsrr($domain, 'MX')) {
                    $fail('The email domain is not valid.');
                }
            }],
            'phone' => 'required|regex:/^\+\d{1,3}\d{7,}$/',
            'message' => 'required|min:10',
            'street' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg',
            'files.*' => 'mimes:pdf'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'phone.required' => 'Phone is required.',
            'message.required' => 'Message is required.',
            'street.required' => 'Street is required.',
            'state.required' => 'State is required.',
            'zip.required' => 'Zip is required.',
            'country.required' => 'Country is required.',
            'images.*.image' => 'Only JPG images are allowed.',
            'images.*.mimes' => 'Only JPG images are allowed.',
            'files.*.mimes' => 'Only PDF files are allowed.',
        ];


    }


}
