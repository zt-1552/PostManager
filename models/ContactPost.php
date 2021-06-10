<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "contact_post".
 *
 * @property int $post_id
 * @property string $contact_name
 * @property string $company_email
 *
 * @property Post $post
 */
class ContactPost extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'contact_name', 'company_email'], 'required'],
            [['post_id'], 'integer'],
            [['contact_name'], 'string', 'max' => 256],
            [['company_email'], 'email'],
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
            'contact_name' => 'Contact Name',
            'company_email' => 'Company Email',
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
}
