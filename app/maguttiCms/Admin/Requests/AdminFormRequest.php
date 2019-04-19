<?php namespace App\maguttiCms\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Input;

class AdminFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized
     * to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return true;
    }

    /**
     * Get the validation rules that
     * apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $model = ($this::segment(2) == 'create') ? $this::segment(count($this::segments())) : $this::segment(count($this::segments()) - 1);
        $this->config = config('maguttiCms.admin.list.section.' . $model);

        $this->modelClass = 'App\\' . $this->config['model'];
        $this->model = new $this->modelClass;
        $rules = [];
        foreach ($this->model->getFieldSpec() as $key => $property) {

            if (data_get($property, 'validation'))
                $rules[$key] = $property['validation'];
            else if (data_get($property, 'required') == 1 && $key != 'id') $rules[$key] = 'required';
        }
        return $rules;
    }
}
