<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ProductRequest extends FormRequest
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
            'name' => 'string|required|max:250|min:3',
            'sku' => 'string|required|max:10|min:3',
            'initial_quantity' => 'integer|required',
            'price' => 'numeric|required'
        ];
    }

    /**
     * Validation messages customized
     * @return array
     */
    public function messages()
    {
        return [
            'name.string' => 'Tipo inválido para o campo NAME',
            'name.required' => 'O campo NAME é obrigatório',
            'name.min:3' => 'O campo NAME não pode ser menor do que 3 caracteres',
            'name.max:250' => 'O campo NAME não pode ser maior do que 250 caracteres',
            'sku.string' => 'Tipo inválido para o campo SKU',
            'sku.required' => 'O campo SKU é obrigatório',
            'sku.min:3' => 'O campo SKU não pode ser menor do que 3 caracteres',
            'sku.max:250' => 'O campo SKU não pode ser maior do que 10 caracteres',
            'inital_quantity.required' => 'O campo INITIAL QUANTITY é obrigatório',
            'inital_quantity.integer' => 'O campo INITIAL QUANTITY deve ser um número',
            'price.required' => 'O campo PRICE é obrigatório',
            'price.numeric' => 'O campo PRICE deve ser um número',
        ];
    }


    /**
     * Failed validation disable redirect
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], 422)
        );
    }

}
