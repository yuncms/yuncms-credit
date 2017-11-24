<?php

namespace yuncms\credit\migrations;

use yii\db\Migration;

class M171120095442Create_credits_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%credits}}', [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'user_id' => $this->integer()->unsigned()->notNull()->comment('User Id'),
            'action' => $this->string(100)->notNull()->comment('Action'),
            'model_id' => $this->integer()->comment('Model Id'),
            'model_subject' => $this->string()->comment('Model Subject'),
            'credits' => $this->integer()->defaultValue(0)->comment('Credits'),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('Created At'),
        ], $tableOptions);

        $this->addForeignKey('{{%credits_fk_1}}', '{{%credits}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

    }

    public function safeDown()
    {
        $this->dropTable('{{%credits}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171120095442Create_credits_table cannot be reverted.\n";

        return false;
    }
    */
}
