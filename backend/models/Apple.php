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
 * @property integer $fallen_at
 * @property integer $created_at
 * @property integer $deleted_at
 */
class Apple extends \yii\db\ActiveRecord
{
    const STATUS_ON_TREE = 10;
    const STATUS_ON_GROUND = 20;
    const STATUS_ROTTEN = 30;

    public function __construct($color = null, $config = [])
    {
        parent::__construct($config);
        if ($color !== null) {
            $this->color = $color;
        }
    }

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
            [['created_at'], 'default', 'value' => rand(1000000000, 2000000000)],
            [['size'], 'default', 'value' => 1],
            [['status'], 'default', 'value' => self::STATUS_ON_TREE],
            [['status'], 'integer'],
            [['size'], 'number'],
            [['fallen_at', 'created_at', 'deleted_at'], 'integer'],
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
            'deleted_at' => 'Removed At',
        ];
    }

    public function fallToGround()
    {
        $this->status = self::STATUS_ON_GROUND;
        $this->fallen_at = time();
        $this->save();
    }

    public function eat($percent)
    {
        $this->size = $this->size - $percent / 100;
        $this->save();
    }

    public function remove()
    {
        $this->deleted_at = time();
        $this->save();
    }

    public function rotten()
    {
        $this->status = self::STATUS_ROTTEN;
        $this->save();
    }

    public function createRandom()
    {
        $apple = new Apple('#' . dechex(rand(1000000, 10000000)));
        $apple->save();
    }

    public function getStatusLabel()
    {
        $labels = self::labels();
        if (isset($labels[$this->status])) {
            return $labels[$this->status];
        }
    }

    public static function labels()
    {
        return [
            self::STATUS_ON_TREE => 'ON TREE',
            self::STATUS_ON_GROUND => 'ON THE GROUND',
            self::STATUS_ROTTEN => 'ROTTEN',
        ];
    }
}
