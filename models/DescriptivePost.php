<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "descriptive_post".
 *
 * @property int $post_id
 * @property string $position_description
 * @property int $salary
 * @property string $starts_at
 * @property string $ends_at
 *
 * @property Post $post
 */
class DescriptivePost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'descriptive_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'starts_at', 'ends_at'], 'required'],
            [['post_id', 'salary'], 'integer'],
            [['starts_at', 'ends_at'], 'integer'],
            [['position_description'], 'string', 'max' => 256],
            [['post_id'], 'unique'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'position_description' => 'Position Description',
            'salary' => 'Salary',
            'starts_at' => 'Starts At',
            'ends_at' => 'Ends At',
        ];
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }


    public function getDateStart()
    {
        return $this->starts_at ? date('d.m.Y', $this->starts_at) : '';
    }

    public function setDateStart($date)
    {
        $this->starts_at = $date ? strtotime($date) : null;
    }

    public function getDateEnd()
    {
        return $this->ends_at ? date('d.m.Y', $this->ends_at) : '';
    }

    public function setDateEnd($date)
    {
        $this->ends_at = $date ? strtotime($date) : null;
    }

}


