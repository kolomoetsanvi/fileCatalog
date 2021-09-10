<?php

use frontend\rbac\UserRule;
use common\models\User;
use yii\db\Migration;

/**
 * Class m210910_054956_create_rbac_data
 */
class m210910_054956_create_rbac_data extends Migration
{
    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $viewSharewarePrivateFiles = $auth->createPermission('viewSharewarePrivateFiles');
        $viewSharewarePrivateFiles->description = 'Просматривать условно-приватные файлы';
        $auth->add($viewSharewarePrivateFiles);

        $uploadingFiles = $auth->createPermission('uploadingFiles');
        $uploadingFiles->description = 'Загрузка файлов';
        $auth->add($uploadingFiles);

        $viewPrivateFiles = $auth->createPermission('viewPrivateFiles');
        $viewPrivateFiles->description = 'Просматривать приватные файлы';
        $auth->add($viewPrivateFiles);

        $editFiles = $auth->createPermission('editFiles');
        $editFiles->description = 'Редактировать файлы';
        $auth->add($editFiles);

        $rule = new UserRule();
        $auth->add($rule);

        $viewOwnFiles = $auth->createPermission('viewOwnFiles');
        $viewOwnFiles->description = 'Просматривать свои файлы';
        $viewOwnFiles->ruleName = $rule->name;
        $auth->add($viewOwnFiles);
        $auth->addChild($viewOwnFiles, $viewPrivateFiles);

        $editOwnFiles = $auth->createPermission('editOwnFiles');
        $editOwnFiles->description = 'Редактировать свои файлы';
        $editOwnFiles->ruleName = $rule->name;
        $auth->add($editOwnFiles);
        $auth->addChild($editOwnFiles, $editFiles);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $viewSharewarePrivateFiles);
        $auth->addChild($user, $uploadingFiles);
        $auth->addChild($user, $viewOwnFiles);
        $auth->addChild($user, $editOwnFiles);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $viewPrivateFiles);
        $auth->addChild($admin, $editFiles);

        $user = new User([
            'username' => 'admin',
            'auth_key' =>  Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            'email' => 'admin@admin.ru'
        ]);
        if ($user->save()){
            $auth->assign($admin, $user->getId());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}
