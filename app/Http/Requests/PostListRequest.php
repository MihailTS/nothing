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


    public function getFrom():?int
    {
        return $this->get('from');
    }

    /**
     * get filter items array
     * @return array
     */
    public function getTags():?array
    {
        $rawTags = $this->getRawTags();
        if($rawTags){
            return explode(',',$rawTags);
        }else{
            return [];
        }
    }


    public function getTag($param, $cast = 'string')
    {
        $filter = $this->getTags();

        if(!isset($filter[$param])){
            return null;
        }

        $value = $filter[$param];
        settype($value, $cast);

        return $value;
    }
    public function getRawTags():?string
    {
        return $this->get('tags');
    }
}
