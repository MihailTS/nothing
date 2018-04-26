<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Contracts\PostListRequest as PostListRequestContract;

class PostListRequest extends FormRequest  implements PostListRequestContract
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
            'from' => 'integer',
            'filter' => 'string',
        ];
    }


    public function getFrom():int
    {
        return $this->get('from');
    }

    /**
     * get filter items array
     * @return array
     */
    public function getFilter():array
    {
        return explode(',',$this->getRawFilter());
    }

    /**
     * @param string $param
     * @param string $cast
     * @return mixed|null
     */
    public function getFilterParam(string $param, string $cast = 'string'):?mixed
    {
        $filter = $this->getFilter();

        if(!isset($filter[$param])){
            return null;
        }

        $value = $filter[$param];
        settype($value, $cast);

        return $value;
    }
    public function getRawFilter():string
    {
        return $this->get('filter');
    }
}
