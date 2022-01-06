<?php

namespace App\Http\Requests;

use App\Models\Place;
use DateTime;
use Illuminate\Foundation\Http\FormRequest;

class CreateEventForm extends FormRequest
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
        return [
            'title' => ['required', 'max:255'],
            'start' => ['required'],
            'end' => ['required'],
            'description' => [],
            'place' => ['required'],
            // 'invited' => []
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->place != null && Place::where('name', "=", $this->place)->count() == 1) {
                $validator->errors()->add('place', 'Musisz podać pełną nazwę miejsca.');
            }
            if (new DateTime($this->start) > new DateTime($this->end)) {
                $validator->errors()->add('end', 'Wydarzenie musi zakończyć się po rozpoczęciu.');
            }
        });
    }
}