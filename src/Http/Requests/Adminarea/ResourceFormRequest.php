<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Requests\Adminarea;

use Illuminate\Foundation\Http\FormRequest;

class ResourceFormRequest extends FormRequest
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
        $resource = $this->route('resource') ?? app('cortex.bookings.resource');
        $resource->updateRulesUniques();

        return $resource->getRules();
    }
}
