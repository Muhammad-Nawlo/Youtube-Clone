<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%video}}`.
 */
class m220411_140356_create_video_table extends Migration
{
    const TABLE_NAME = '{{%video}}';

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
            'video_id' => $this->string(10)->notNull(),
            'video_name' => $this->string(512)->notNull(),
            'title' => $this->string(512)->notNull(),
            'description' => $this->text()->notNull(),
            'tags' => $this->string(512)->notNull(),
            'status' => $this->integer(1)->notNull(),
            'has_thumbnail' => $this->boolean()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer()->notNull()
        ],$tableOptions);
        $this->addPrimaryKey('pk_video', self::TABLE_NAME, 'video_id');
        $this->addForeignKey('fk_video_user', self::TABLE_NAME, 'created_by', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_video_user', self::TABLE_NAME);
        $this->dropPrimaryKey('pk_video', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
