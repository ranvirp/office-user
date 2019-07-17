<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190604_113659_new_table
 */
class m190604_113659_new_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $transaction = $this->db->beginTransaction();
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32)',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING . '',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        /*
        $user = new \app\modules\users\models\User;
        $user->username = 'admin';
        $user->setPassword('admin');
        $user->save();
        */
        $this->createTable('{{%login_history}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'logintime' => Schema::TYPE_INTEGER,
            'sessionid' => Schema::TYPE_STRING . ' NOT NULL',
            'logouttime' => Schema::TYPE_INTEGER,

        ], $tableOptions);

        $this->createTable('{{%designation}}', [
            'id' => Schema::TYPE_PK,
            'designation_type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'level_id' => Schema::TYPE_STRING . ' NOT NULL',
            'officer_name_hi' => Schema::TYPE_STRING . '(100) ',
            'officer_name_en' => Schema::TYPE_STRING . '(32) ',
            'officer_mobile' => Schema::TYPE_STRING . '(12) ',
            'officer_mobile1' => Schema::TYPE_STRING . '(12) ',
            'officer_email' => Schema::TYPE_STRING . '(32) ',
            'officer_userid' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name_hi' => Schema::TYPE_STRING . ' NOT NULL',
            'name_en' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->createTable('{{%designation_type}}', [
            'id' => Schema::TYPE_PK,
            'level_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name_hi' => Schema::TYPE_STRING . ' NOT NULL',
            'name_en' => Schema::TYPE_STRING . ' NOT NULL',
            'shortcode' => Schema::TYPE_STRING . '(10) NOT NULL',

            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->createTable('{{%level}}', [
            'id' => Schema::TYPE_PK,
            'dept_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name_hi' => Schema::TYPE_STRING . ' NOT NULL',
            'name_en' => Schema::TYPE_STRING . ' NOT NULL',
            'class_name' => Schema::TYPE_STRING . '(50) NOT NULL',

            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->createTable('{{%department}}', [
            'id' => Schema::TYPE_PK,
            'name_hi' => Schema::TYPE_STRING . ' NOT NULL',
            'name_en' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->createTable('{{%websitemanagement}}', [
            'id' => Schema::TYPE_PK,
            'name_hi' => Schema::TYPE_STRING . ' NOT NULL',
            'name_en' => Schema::TYPE_STRING . ' NOT NULL',
        ], $tableOptions);

        $this->update('{{%websitemanagement}}',['code'=>'1'],['id'=>1]);
        $this->dropColumn('{{%websitemanagement}}','id');
        $this->addPrimaryKey('web_pk','{{%websitemanagement}}','code');

        $web = new rp\users\models\WebsiteManagement;
        $web->name_en = 'Web Manager';
        $web->name_hi = 'Web Manager';
        $web->save();
        $dept = new rp\users\models\Department;
        $dept->name_hi = 'WebAdministration';
        $dept->name_en = 'WebAdministration';
        $dept->save();
        $level = new rp\users\models\Level;
        $level->dept_id = 1;
        $level->name_hi = 'Web Administration';
        $level->name_en = 'Web Administration';
        $level->class_name = 'rp\users\models\WebsiteManagement';
        $level->save();
        $dt = new rp\users\models\DesignationType;
        $dt->level_id = 1;
        $dt->shortcode = 'webadmin';
        $dt->name_en = 'Web Administrator';
        $dt->name_hi = 'Web Administrator';
        $dt->save();
        $d = new rp\users\models\Designation;
        $d->designation_type_id = 1;
        $d->name_en = 'Web Administrator';
        $d->name_hi = 'Web Administrator';
        $d->officer_userid = 1;
        $d->level_id = 1;
        $d->save();

        $authManager = Yii::$app->authManager;
        if ($authManager) {
            $webadminrole = $authManager->createRole('webadmin');
            $authManager->add($webadminrole);

            $permissions = ['edit', 'delete', 'create', 'view', 'index', 'update'];
            $tables = ['department', 'level', 'designationtype', 'designation'];
            foreach ($tables as $table) {
                foreach ($permissions as $permission) {
                    if (!($authpermission = $authManager->getPermission($table . $permission))) {
                        $authpermission = $authManager->createPermission($table . $permission);
                        $authpermission->description = $permission . ' of controller ' . $table;
                        $authManager->add($authpermission);
                    }
                    $authManager->addChild($webadminrole, $authpermission);
                }
            }
            $authManager->assign($webadminrole, 1);
        }
        //addForeignKey( $name, $table, $columns, $refTable, $refColumns, $delete = null, $update = null )
        $this->addForeignKey('designation_designation_type_fkey', '{{%designation}}', 'designation_type_id', '{{%designation_type}}', 'id');

        $this->addForeignKey('designation_type_level_fkey', '{{%designation_type}}', 'level_id', '{{%level}}', 'id');
        $this->addForeignKey('level_department_fkey', '{{%level}}', 'dept_id', '{{%department}}', 'id');
        $this->createTable('{{%reply}}', [
            'id' => Schema::TYPE_PK,
            'content_type' => Schema::TYPE_STRING . '(50) NOT NULL',
            'content_type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'content' => Schema::TYPE_TEXT,
            'attachments' => Schema::TYPE_TEXT,
            'author_id' => Schema::TYPE_INTEGER,
            'create_time' => Schema::TYPE_INTEGER,
            'update_time' => Schema::TYPE_INTEGER,
            'attentionof' => Schema::TYPE_INTEGER,
        ], $tableOptions);
        $this->createTable('{{%file}}', [
            'id' => Schema::TYPE_PK,
            'model_type' => Schema::TYPE_STRING . '(500)',
            'model_pk' => Schema::TYPE_STRING . '(40)',
            'size' => Schema::TYPE_INTEGER,
            'mime' => Schema::TYPE_STRING . '(1000)',
            'unique_id' => Schema::TYPE_STRING . '(1000) default NULL',
            'url' => Schema::TYPE_TEXT,
            'path' => Schema::TYPE_TEXT,
            'filename' => Schema::TYPE_TEXT,
            'title' => Schema::TYPE_STRING . '(1000)',
            'uploaded_by' => Schema::TYPE_INTEGER,
            'uploaded_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createTable('{{%request}}', [
            'id' => Schema::TYPE_PK,
            'request_type_id' => Schema::TYPE_INTEGER,
            'request_subject'=>Schema::TYPE_STRING.' NOT NULL',
            'content'=>Schema::TYPE_TEXT,
            'attachments'=>Schema::TYPE_TEXT,
            'author_id'=>Schema::TYPE_INTEGER,
            'create_time'=>Schema::TYPE_INTEGER,
            'update_time'=>Schema::TYPE_INTEGER,

        ], $tableOptions);
        $this->createTable('{{%marking}}', [
            'id' => Schema::TYPE_PK,
            'request_type' => Schema::TYPE_TEXT,
            'parent_marking_id' => Schema::TYPE_INTEGER,

            'request_id' => Schema::TYPE_INTEGER,
            'sender'=>Schema::TYPE_INTEGER,
            'receiver'=>Schema::TYPE_INTEGER,
            'sender_name' => Schema::TYPE_TEXT,
            'sender_mobileno' => Schema::TYPE_STRING,
            'sender_designation_type_id' => Schema::TYPE_INTEGER,

            'receiver_name' => Schema::TYPE_TEXT,
            'receiver_mobileno' => Schema::TYPE_STRING,
            'receiver_designation_type_id' => Schema::TYPE_INTEGER,

            'statustarget' => Schema::TYPE_INTEGER,
            'purpose' => Schema::TYPE_TEXT,
            'canmark' => Schema::TYPE_INTEGER,


            'dateofmarking'=>Schema::TYPE_DATE,
            'deadline'=>Schema::TYPE_DATE,
            'status'=>Schema::TYPE_INTEGER,
            'create_time'=>Schema::TYPE_INTEGER,
            'update_time'=>Schema::TYPE_INTEGER,
            'read_time'=>Schema::TYPE_INTEGER.' NULL',
            'created_by'=>Schema::TYPE_INTEGER,
            'updated_by'=>Schema::TYPE_INTEGER,

        ], $tableOptions);



        $this->createIndex('marking_indices','{{%marking}}',['request_id','request_type']);
        $this->createIndex('designation_type_indices','{{%marking}}',['receiver_designation_type_id']);
        $this->createTable('{{%request_type}}', [
            'id' => Schema::TYPE_PK,
            'category' => Schema::TYPE_INTEGER,
            'name'=>Schema::TYPE_STRING,


        ], $tableOptions);
        $this->addForeignKey('request_marking_fkey','{{%marking}}','request_id','{{%request}}','id');
        $this->addForeignKey('request_request_type','{{%request}}','request_type_id','{{%request_type}}','id');

        $this->createTable('{{%mandal}}', [
            'code' => Schema::TYPE_STRING.' PRIMARY KEY',
            'name_hi'=>Schema::TYPE_STRING,
            'name_en'=>Schema::TYPE_STRING,
        ],$tableOptions);
        $this->createTable('{{%district}}', [
            'code' => Schema::TYPE_STRING.' PRIMARY KEY',
            'mandal_code'=>Schema::TYPE_STRING,
            'name_hi'=>Schema::TYPE_STRING,
            'name_en'=>Schema::TYPE_STRING,
        ],$tableOptions);
        $this->createTable('{{%block}}', [
            'code' => Schema::TYPE_STRING.' PRIMARY KEY',
            'district_code'=>Schema::TYPE_STRING,
            'name_hi'=>Schema::TYPE_STRING,
            'name_en'=>Schema::TYPE_STRING,
        ],$tableOptions);
        $this->createTable('{{%panchayat}}', [
            'code' => Schema::TYPE_STRING.' PRIMARY KEY',
            'block_code'=>Schema::TYPE_STRING,
            'name_hi'=>Schema::TYPE_STRING,
            'name_en'=>Schema::TYPE_STRING,
        ],$tableOptions);
        $this->createTable('{{%tehsil}}', [
            'code' => Schema::TYPE_STRING.' PRIMARY KEY',
            'district_code'=>Schema::TYPE_STRING,
            'name_hi'=>Schema::TYPE_STRING,
            'name_en'=>Schema::TYPE_STRING,
        ],$tableOptions);
        $this->createTable('{{%revenue_village}}', [
            'code' => Schema::TYPE_STRING.' PRIMARY KEY',
            'tehsil_code'=>Schema::TYPE_STRING,
            'name_hi'=>Schema::TYPE_STRING,
            'name_en'=>Schema::TYPE_STRING,
        ],$tableOptions);
        $this->createTable('{{%photo}}', [
            'id' => Schema::TYPE_PK,
            'bwid' => Schema::TYPE_STRING,
            'title'=>Schema::TYPE_STRING,
            'height'=>Schema::TYPE_INTEGER,
            'width'=>Schema::TYPE_INTEGER,
            'mime'=>Schema::TYPE_STRING,
            'size'=>Schema::TYPE_INTEGER,
            'url'=>Schema::TYPE_STRING,
            'path'=>Schema::TYPE_STRING,
            'filename'=>Schema::TYPE_STRING,
            'gpslat'=>Schema::TYPE_DOUBLE,
            'gpslong'=>Schema::TYPE_DOUBLE,
            'gpsalt'=>Schema::TYPE_DOUBLE,
            'gpsacc'=>Schema::TYPE_DOUBLE,
            'thumbnail'=>Schema::TYPE_TEXT,
            'approved'=>Schema::TYPE_SMALLINT,
            'imei'=>Schema::TYPE_STRING,
            'mobileno'=>Schema::TYPE_STRING,
            'devicesoftware'=>Schema::TYPE_STRING,
            'created_at'=>Schema::TYPE_INTEGER,
            'created_by'=>Schema::TYPE_INTEGER,
            'district'=>Schema::TYPE_TEXT,
            'block'=>Schema::TYPE_TEXT,
            'panchayat'=>Schema::TYPE_TEXT,
            'municipal'=>Schema::TYPE_TEXT,




        ],$tableOptions);
        $this->createTable('{{%scheme}}', [
            'id' => Schema::TYPE_PK,
            'code' => Schema::TYPE_STRING,
            'name_hi'=>Schema::TYPE_TEXT,
            'name_en'=>Schema::TYPE_TYPE_TEXT,
            'description'=>Schema::TYPE_STRING,

            'finyear'=>Schema::TYPE_STRING,
            'documents'=>Schema::TYPE_TEXT,
            'noofworks'=>Schema::TYPE_INTEGER,
            'totalcost'=>Schema::TYPE_DOUBLE,
        ],$tableOptions);
        $this->createTable('{{%work}}', [
            'id' => Schema::TYPE_PK,
            'workid' => Schema::TYPE_STRING." NOT NULL",
            'work_admin'=>Schema::TYPE_INTEGER,
            'name_hi'=>Schema::TYPE_STRING,
            'name_en'=>Schema::TYPE_STRING,
            'description'=>Schema::TYPE_TEXT,
            'agency_id'=>Schema::TYPE_INTEGER,
            'work_type_id'=>Schema::TYPE_INTEGER,
            'totalvalue'=>Schema::TYPE_DOUBLE,


            'scheme_id'=>Schema::TYPE_INTEGER,
            'district_id'=>Schema::TYPE_INTEGER,
            'address'=>Schema::TYPE_STRING,

            'gpslat'=>Schema::TYPE_DOUBLE,
            'gpslong'=>Schema::TYPE_DOUBLE,
            'gpsalt'=>Schema::TYPE_DOUBLE,
            'gpsacc'=>Schema::TYPE_DOUBLE,

            'created_at'=>Schema::TYPE_INTEGER,
            'created_by'=>Schema::TYPE_INTEGER,
            'district'=>Schema::TYPE_STRING,
            'block'=>Schema::TYPE_STRING,
            'panchayat'=>Schema::TYPE_STRING,
            'municipality'=>Schema::TYPE_STRING,
            'ward'=>Schema::TYPE_STRING,
            'status'=>Schema::TYPE_SMALLINT,
            'remarks'=>Schema::TYPE_TEXT,




        ],$tableOptions);
        $this->createTable('{{%work_progress}}', [
            'id' => Schema::TYPE_PK,
            'work_id' => Schema::TYPE_STRING,
            'progress_date'=>Schema::TYPE_DATE,
            'exp'=>Schema::TYPE_DOUBLE,
            'phy'=>Schema::TYPE_DOUBLE,
            'fin'=>Schema::TYPE_DOUBLE,
            'created_at'=>Schema::TYPE_INTEGER,
            'created_by'=>Schema::TYPE_INTEGER,
        ],$tableOptions);
        $this->createTable('{{%work_type}}', [
            'id' => Schema::TYPE_PK,
            'code' => Schema::TYPE_STRING,
            'name_hi' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,

        ],$tableOptions);
        $this->createTable('{{%parameter}}', [
            'id' => Schema::TYPE_PK,
            'type'=>Schema::TYPE_INTEGER,
            'link'=>Schema::TYPE_STRING,
            'parser'=>Schema::TYPE_TEXT,
            'name_hi'=>Schema::TYPE_STRING,
            'name_en'=>Schema::TYPE_STRING,
            'description'=>Schema::TYPE_TEXT,
            'shortcode'=>Schema::TYPE_STRING,
            'weight'=>Schema::TYPE_INTEGER,
            'unit'=>Schema::TYPE_STRING,
            'periodicity'=>Schema::TYPE_INTEGER,


        ],$tableOptions);

CREATE TABLE parameter_parse (
        id integer NOT NULL,
    parameter_id integer,
    json_value text,
    update_time integer,
    dld_data text,
    level integer DEFAULT 0,
    district_code character varying(4) DEFAULT '0'::character varying
);
CREATE TABLE parameter_target (
        id integer NOT NULL,
    parameter_id integer,
    district_id character varying(255),
    parameter_target character varying(255),
    month integer
);
CREATE TABLE parameter_value (
        id integer NOT NULL,
    parameter_id integer,
    district_id character varying(255),
    parameter_value character varying(255),
    update_time integer
);

        $transaction->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('designation_designation_type_fkey', '{{%designation}}');
        $this->dropForeignKey('designation_type_level_fkey', '{{%designation_type}}');
        $this->dropForeignKey('level_department_fkey', '{{%level}}');
        $this->dropTable('{{%designation}}');
        $this->dropTable('{{%designation_type}}');
        $this->dropTable('{{%level}}');
        $this->dropTable('{{%department}}');
        $this->dropTable('{{%websitemanagement}}');
        $this->dropTable('{{user}}');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190604_113659_new_table cannot be reverted.\n";

        return false;
    }
    */
}
