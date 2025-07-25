<?php

namespace App\Http\Requests\Setup;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'RX_Code' => 'required',
            'RX_Symbol' => 'required',
            'RX_Desc' => 'required',
            'RX_UnitName' => 'required',
            'RX_IsActive' => 'boolean',
            'RX_SubUnitName' => 'nullable|numeric',
            'RX_SubUnitRatio' => 'nullable|numeric',
            'RX_ISOSubUnitRatio' => 'nullable|numeric',
        ];
    }

    public function attributes(): array
    {
        return [
            'RX_Code' => 'Currency Code',
            'RX_Symbol' => 'Symbol',
            'RX_Desc' => 'Description',
            'RX_UnitName' => 'Unit Name',
        ];
    }
}
