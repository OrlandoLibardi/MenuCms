<?php

namespace OrlandoLibardi\MenuCms\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
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

        switch($this->method()){
            case 'POST':
                $rules = [
                    'title'   => 'required|string|max:255',
                    'url'     => 'required',
                    'parent'  => 'sometimes|exists:menu_items,id',
                    'menu_id' => 'required|exists:menus,id'
                ];   
            break;    
            case 'PUT':
                $rules = [
                    'title'    => 'required|string|max:255',
                    'url'      => 'required',
                    'parent'   => 'sometimes|exists:menu_items,id',
                    'menu_id'  => 'required|exists:menus,id',
                    'order_at' => 'required|numeric'
                ]; 
            break;
            case 'PATCH':
                $rules = [
                    'id'    => 'required|exists:menu_items,id',
                    'order' => 'required|min:0|max:1',
                ]; 
            break;
            case 'DELETE':
                $rules = [
                    'id.*' => 'required|exists:menu_items,id' 
                ];
            break;
            default:
                 $rules = [];
        }

        return $rules;

    
    }
    
}
