<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Requests\Adminarea;

use Carbon\Carbon;
use Rinvex\Support\Traits\Escaper;
use Illuminate\Foundation\Http\FormRequest;

class BookingFormRequest extends FormRequest
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

        // Calculate price
        $room = app('cortex.bookings.room')->find($this->get('room_id'));
        $endsAt = $this->get('ends_at') ? new Carbon($this->get('ends_at')) : null;
        $startsAt = $this->get('starts_at') ? new Carbon($this->get('starts_at')) : null;
        list($price, $priceEquation, $currency) = app('rinvex.bookings.booking')->calculatePrice($room, $startsAt, $endsAt);

        // Fill missing fields
        $data['ends_at'] = $endsAt;
        $data['starts_at'] = $startsAt;
        $data['bookable_type'] = 'room';
        $data['customer_type'] = 'member';
        $data['price_equation'] = $priceEquation;
        $data['currency'] = $currency;
        $data['price'] = $price;

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
        $booking = $this->route('booking') ?? app('rinvex.bookings.booking');
        $booking->updateRulesUniques();

        return $booking->getRules();
    }
}
