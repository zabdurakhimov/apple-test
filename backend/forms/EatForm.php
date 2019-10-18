<?php


namespace backend\forms;


use backend\models\Apple;
use yii\base\Model;

class EatForm extends Model
{
    /**
     * @var Apple
     */
    public $apple;
    /**
     * @var integer
     */
    public $size;



    public function rules()
    {
        return [
            [['size'],'integer'],
            [['size'],function($attribute,$params){
                if ($this->size == null) {
                    $this->addError($attribute, "size is required!");
                }
                if ($this->size > $this->apple->size*100) {
                    $this->addError($attribute, "size cannot be more than the actual!");
                }
            }],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->apple->size = $this->apple->size - $this->size/100;
        $this->apple->save();
        if($this->apple->size == 0){
            $this->apple->remove();
        }
        return true;
    }
}