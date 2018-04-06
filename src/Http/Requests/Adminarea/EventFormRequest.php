<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Requests\Adminarea;

use Carbon\Carbon;
use Rinvex\Support\Traits\Escaper;
use Illuminate\Foundation\Http\FormRequest;

class EventFormRequest extends FormRequest
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

        $duration = explode(' - ', $data['duration']);
        $data['starts_at'] = (new Carbon($duration[0]))->toDateTimeString();
        $data['ends_at'] = (new Carbon($duration[1]))->toDateTimeString();

        $this->replace($data);
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    public function withValidator($validator): void
    {
        // Sanitize input data before submission
        $this->replace($this->escape($this->all()));
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

        return array_merge($event->getRules(), [
            'duration' => 'required',
        ]);
    }
}
