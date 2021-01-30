<?php

namespace SquadMS\AdminConfig\Http\Requests\AdminConfig;

use Illuminate\Foundation\Http\FormRequest;

class DeleteAdminConfig extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $adminConfig = $this->route('adminconfig');
        return $adminConfig && $this->user()->can('admin servergroups');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
