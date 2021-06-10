<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $type
 * @property string $company_name
 * @property string $position
 *
 * @property ContactPost $contactPost
 * @property DescriptivePost $descriptivePost
 * @property PostsQueue[] $postsQueues
 */
class Post extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'post';
    }

    public function rules()
    {
        return [
            [['type_form', 'company_name', 'position'], 'required'],
            [['type_form'], 'string', 'max' => 32],
            [['company_name', 'position'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels()
    {
        return [
            'type_form' => 'Тип формы',
            'company_name' => 'Название компании',
            'position' => 'Должность',
        ];
    }

    public function getContactPost()
    {
        return $this->hasOne(ContactPost::class, ['post_id' => 'id']);
    }


    public function getDescriptivePost()
    {
        return $this->hasOne(DescriptivePost::class, ['post_id' => 'id']);
    }


    public function getPostsQueues()
    {
        return $this->hasOne(PostsQueue::class, ['post_id' => 'id']);
    }
}
