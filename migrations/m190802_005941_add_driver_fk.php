<?php

use yii\db\Migration;

class m190802_005941_add_driver_fk extends Migration
{

    public function up()
    {
        $this->addColumn(
            \app\models\JobContainer::tableName()
            , 'driver_id'
            , $this->integer(10)->unsigned()->after('truckVendor_id')
        );
        $this->createIndex('driver', \app\models\JobContainer::tableName(), 'driver_id');
        $this->addForeignKey(
            'fk_jobcontainer_driver'
            , \app\models\JobContainer::tableName()
            , 'driver_id'
            , \app\models\TruckSupervisor::tableName()
            , 'id'
        );
    }

    public function down()
    {
        $this->dropPrimaryKey('fk_jobcontainer_driver', \app\models\JobContainer::tableName());
        $this->dropIndex(\app\models\JobContainer::tableName(), 'driver');
        $this->dropColumn(\app\models\JobContainer::tableName(), 'driver_id');
    }
    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */

}