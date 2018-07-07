<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SermonsRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'title' => 'required|unique:sermons',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'title' => 'required|unique:sermons,title,'.$this->request->get('sermon_id'),
                ];
            }
            default:
                break;
        }
    }
}
