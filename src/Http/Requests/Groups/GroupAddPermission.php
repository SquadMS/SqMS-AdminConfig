<?php

namespace SquadMS\AdminConfig\Http\Requests\Groups;

use Illuminate\Foundation\Http\FormRequest;

class GroupAddPermission extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('admin servergroups');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'permission_id' => 'integer|exists:server_permissions,id'
        ];
    }
}
