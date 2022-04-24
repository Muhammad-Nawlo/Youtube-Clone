<?php

use yii\db\Migration;

/**
 * Class m220419_112421_create_fulltext_column
 */
class m220419_112421_create_fulltext_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE video ADD FULLTEXT(title,description,tags)');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220419_112421_create_fulltext_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220419_112421_create_fulltext_column cannot be reverted.\n";

        return false;
    }
    */
}
