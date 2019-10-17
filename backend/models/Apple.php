<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $color
 * @property int $status
 * @property double $size
 * @property string $fallen_at
 * @property string $created_at
 * @property string $deleted_at
 */
class Apple extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color'], 'required'],
            [['color'], 'default', 'value'=> '#' . dechex(rand(0,10000000))],
            [['status'], 'integer'],
            [['size'], 'number'],
            [['fallen_at', 'created_at', 'deleted_at'], 'safe'],
            [['color'], 'string', 'max' => 24],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Color',
            'status' => 'Status',
            'size' => 'Size',
            'fallen_at' => 'Fallen At',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
