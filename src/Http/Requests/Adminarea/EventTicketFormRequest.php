<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Requests\Adminarea;

use Rinvex\Support\Traits\Escaper;
use Illuminate\Foundation\Http\FormRequest;

class EventTicketFormRequest extends FormRequest
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

        $data['ticketable_id'] = optional($this->route('event'))->getKey();
        $data['ticketable_type'] = optional($this->route('event'))->getMorphClass();

        $this->replace($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $eventTicket = $this->route('ticket') ?? app('cortex.bookings.event_ticket');
        $eventTicket->updateRulesUniques();

        return $eventTicket->getRules();
    }
}
