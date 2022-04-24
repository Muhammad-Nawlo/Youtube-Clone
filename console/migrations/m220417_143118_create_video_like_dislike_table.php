<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%video_like_dislike}}`.
 */
class m220417_143118_create_video_like_dislike_table extends Migration
{
    const TABLE_NAME = '{{%video_like_dislike}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName == 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'video_id' => $this->string(10)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'type' => $this->boolean(),
            'created_at' => $this->integer(11)->notNull()
        ], $tableOptions);

        $this->addForeignKey('fk_video_like_dislike_video', self::TABLE_NAME, 'video_id', 'video', 'video_id');
        $this->addForeignKey('fk_video_like_dislike_user', self::TABLE_NAME, 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_video_like_dislike_user', self::TABLE_NAME);
        $this->dropForeignKey('fk_video_like_dislike_video', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
