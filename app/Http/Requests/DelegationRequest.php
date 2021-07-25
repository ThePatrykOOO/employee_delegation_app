<?php

namespace App\Http\Requests;

use App\Rules\EmployeeInDelegationRule;
use App\Rules\IsCountryExists;
use Illuminate\Foundation\Http\FormRequest;

class DelegationRequest extends FormRequest
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
            'employee_id' => ['required', ' exists:employees,id', new EmployeeInDelegationRule($this->get('start'), $this->get('end'))],
            'start' => 'required|date',
            'end' => 'date|after:start',
            'country' => ['required', 'string', new IsCountryExists()],
        ];
    }

    public function attributes()
    {
        return [
            'start' => 'start date delegation',
            'end' => 'end date delegation',
        ];
    }
}
