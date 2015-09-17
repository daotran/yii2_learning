<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\commands\rules\AuthorRule;
use app\commands\rules\UserGroupRule;

class RbacController extends Controller
{
    public function actionInit($id = null)
    {
        $auth = Yii::$app->authManager;

        // RULES
        // add the rule
        $rule = new AuthorRule();
        $auth->add($rule);

        $groupRule = new UserGroupRule();
        $auth->add($groupRule);

        // PERMISSIONS
        // add "createPost" permission
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);


        // ROLES
        // add "author" role and give this role the "createPost" permission
        $author = $auth->createRole('author');
        $author->description = 'Author Role';
        $author->ruleName = $groupRule->name;
        $auth->add($author);
        $auth->addChild($author, $createPost);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $admin->description = 'Admin Role';
        $admin->ruleName = $groupRule->name;
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author); // admin will have all permissions of author's role

        // ASSIGNMENTS
        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($author, 2);
        $auth->assign($admin, 1);
  
        // add the "updateOwnPost" permission and associate the rule with it in order to author can update his own post
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Update own post';
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);

        // "updateOwnPost" will be used from "updatePost"
        $auth->addChild($updateOwnPost, $updatePost);

        // allow "author" to update their own posts
        $auth->addChild($author, $updateOwnPost);

        // Admin assignments
        if ($id !== null) {
            $auth->assign($admin, $id);
        }
    }
}