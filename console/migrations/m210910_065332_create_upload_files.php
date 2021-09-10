<?php

use yii\db\Migration;

/**
 * Class m210910_065332_create_upload_files
 */
class m210910_065332_create_upload_files extends Migration
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

        if (Yii::$app->db->getTableSchema('file_access') === null) {
            $this->createTable('file_access', [
                'file_access_id' => $this->primaryKey(),
                'file_access_descr' =>  $this->string()->notNull(),
            ],  $tableOptions);
        }

        $this->insert('file_access', [
            'file_access_id' => 1,
            'file_access_descr' => 'Публичный',
        ]);
        $this->insert('file_access', [
            'file_access_id' => 2,
            'file_access_descr' => 'Условно-приватный',
        ]);
        $this->insert('file_access', [
            'file_access_id' => 3,
            'file_access_descr' => 'Приватный',
        ]);


        if (Yii::$app->db->getTableSchema('upload_files') === null) {
            $this->createTable('upload_files', [
                'id' => $this->primaryKey(),
                'file_path' => $this->string()->notNull()->unique(),
                'file_name' => $this->string()->notNull(),
                'file_type' => $this->string(30)->notNull(),
                'file_access' => $this->integer()->notNull(),
                'status' => $this->smallInteger()->notNull(),
                'create_date' => $this->integer()->notNull(),
                'created_by_user' => $this->integer()->notNull(),
            ],  $tableOptions);

            $this->addForeignKey('FK_upload_files_file_access', 'upload_files', 'file_access', 'file_access', 'file_access_id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('FK_upload_files_user', 'upload_files', 'created_by_user', 'user', 'id', 'CASCADE', 'CASCADE');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if (Yii::$app->db->getTableSchema('upload_files') !== null) {
            $this->dropTable('upload_files');
        }

        if (Yii::$app->db->getTableSchema('file_access') !== null) {
            $this->dropTable('file_access');
        }
    }
}
