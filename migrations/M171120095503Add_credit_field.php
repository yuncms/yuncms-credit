<?php

namespace yuncms\credit\migrations;

use yii\db\Migration;

class M171120095503Add_credit_field extends Migration
{

    public function safeUp()
    {
        $this->addColumn('{{%user_extra}}', 'credits', $this->integer()->unsigned()->defaultValue(0)->comment('Credits'));

    }

    public function safeDown()
    {
        $this->dropColumn('{{%user_extra}}', 'credits');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171120095503Add_credit_field cannot be reverted.\n";

        return false;
    }
    */
}
