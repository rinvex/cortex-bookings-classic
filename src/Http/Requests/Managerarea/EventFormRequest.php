<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Requests\Managerarea;

use Illuminate\Foundation\Http\FormRequest;

class EventFormRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $event = $this->route('event') ?? app('cortex.bookings.event');
        $event->updateRulesUniques();

        return $event->getRules();
    }
}
