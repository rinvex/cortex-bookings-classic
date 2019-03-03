<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Requests\Adminarea;

use Rinvex\Support\Traits\Escaper;
use Illuminate\Foundation\Http\FormRequest;

class ServiceFormRequest extends FormRequest
{
    use Escaper;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $data = $this->all();

        $data['base_cost'] = (int) $data['base_cost'];

        $this->replace($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $service = $this->route('service') ?? app('cortex.bookings.service');
        $service->updateRulesUniques();
        $rules = $service->getRules();

        $rules['availabilities.*.range'] = ['sometimes', 'required', 'string'];
        $rules['availabilities.*.from'] = ['sometimes', 'required', 'string'];
        $rules['availabilities.*.to'] = ['sometimes', 'required', 'string'];
        $rules['availabilities.*.is_bookable'] = ['sometimes', 'boolean'];
        $rules['availabilities.*.priority'] = ['sometimes', 'nullable', 'integer'];

        $rules['rates.*.range'] = ['sometimes', 'required', 'string'];
        $rules['rates.*.from'] = ['sometimes', 'required', 'string'];
        $rules['rates.*.to'] = ['sometimes', 'required', 'string'];
        $rules['rates.*.base_cost'] = ['sometimes', 'nullable', 'numeric'];
        $rules['rates.*.unit_cost'] = ['sometimes', 'required', 'numeric'];

        return $rules;
    }
}
