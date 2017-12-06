<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Requests\Tenantarea;

use Illuminate\Foundation\Http\FormRequest;

class BookingFormRequest extends FormRequest
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
        $booking = $this->route('booking') ?? app('rinvex.bookings.booking');
        $booking->updateRulesUniques();

        return $booking->getRules();
    }
}
