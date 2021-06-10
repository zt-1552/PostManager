<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts_queue".
 *
 * @property int $id
 * @property int $post_id
 * @property string $post_at
 * @property string $notification_sent_at
 *
 * @property Post $post
 */
class PostsQueue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts_queue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'post_at'], 'required'],
            [['post_id', 'post_at', 'notification_sent_at'], 'integer'],
            [['id'], 'unique'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'post_at' => 'Post At',
            'notification_sent_at' => 'Notification Sent At',
        ];
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    public function getDatePostAt()
    {
        return $this->post_at ? date('d.m.Y', $this->post_at) : '';
    }

    public function setDatePostAt($date)
    {
        $this->post_at = $date ? strtotime($date) : null;
    }


}
