<?php

namespace SquadMS\AdminConfig\Http\Requests\AdminConfig;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminConfig extends FormRequest
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
            'name'              => 'required|string|min:2',
            'reserved_group_id' => 'nullable|integer|exists:server_groups,id',
            'main'              => 'nullable|boolean',
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated()
    {
        $validated = parent::validated();

        if (! $this->has('main')) {
            $validated['main'] = false;
        }

        return $validated;
    }
}
