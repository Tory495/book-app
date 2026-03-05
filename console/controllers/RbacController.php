<?php

namespace console\controllers;

use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit(): void
    {
        $auth = \Yii::$app->authManager;

        $createBook = $auth->createPermission('createBook');
        $createBook->description = 'Create a book';
        $auth->add($createBook);

        $updateBook = $auth->createPermission('updateBook');
        $updateBook->description = 'Update a book';
        $auth->add($updateBook);

        $deleteBook = $auth->createPermission('deleteBook');
        $deleteBook->description = 'Delete a book';
        $auth->add($deleteBook);

        $createAuthor = $auth->createPermission('createAuthor');
        $createAuthor->description = 'Create an author';
        $auth->add($createAuthor);

        $updateAuthor = $auth->createPermission('updateAuthor');
        $updateAuthor->description = 'Update an author';
        $auth->add($updateAuthor);

        $deleteAuthor = $auth->createPermission('deleteAuthor');
        $deleteAuthor->description = 'Delete an author';
        $auth->add($deleteAuthor);

        $user = $auth->createRole('user');
        $auth->add($user);

        $auth->addChild($user, $createBook);
        $auth->addChild($user, $updateBook);
        $auth->addChild($user, $deleteBook);

        $auth->addChild($user, $createAuthor);
        $auth->addChild($user, $updateAuthor);
        $auth->addChild($user, $deleteAuthor);

        echo "Rbac roles and permissions created." . PHP_EOL;
    }

    public function actionAssign($userId): void
    {
        $auth = \Yii::$app->authManager;
        $role = $auth->getRole('user');

        if ($role) {
            $auth->assign($role, $userId);
            echo "Role 'user' successfully assigned to user #$userId" . PHP_EOL;

            return;
        }
        
        echo "Role 'user' not found. Run rbac/init first." . PHP_EOL;
    }
}
