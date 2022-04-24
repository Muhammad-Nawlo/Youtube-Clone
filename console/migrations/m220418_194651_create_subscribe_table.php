<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscribe}}`.
 */
class m220418_194651_create_subscribe_table extends Migration
{
    const TABLE_NAME = '{{%subscribe}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'channel_id' => $this->integer(11),
            'user_id' => $this->integer(11),
            'created_at' => $this->integer(11),
        ]);


        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-subscriber-channel_id}}',
            self::TABLE_NAME,
            'channel_id',
            '{{%user}}',
            'id'
        );


        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-subscriber-user_id}}',
            self::TABLE_NAME,
            'user_id',
            '{{%user}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
// drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-subscriber-channel_id}}',
            self::TABLE_NAME
        );


        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-subscriber-user_id}}',
            self::TABLE_NAME
        );


        $this->dropTable('{{%subscriber}}');
    }
}
