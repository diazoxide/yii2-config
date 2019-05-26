<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

use yii\db\Migration;
use yii\db\Schema;

class m100000_000001_config_rules extends Migration
{
    use \diazoxide\blog\traits\ModuleTrait;

    public $rules = [];
    public $permissions = [

        ['CONFIG_DEFAULT_INDEX','View Config Dashboard'],
        ['CONFIG_DEFAULT_CLEAR_CACHE','Config Clear Cache'],
        ['CONFIG_MODULES_INDEX', 'View Config modules'],
        ['CONFIG_MODULES_VIEW', 'View Config module'],
        ['CONFIG_MODULES_CREATE', 'Create Config module'],
        ['CONFIG_MODULES_UPDATE', 'Update Config module'],
        ['CONFIG_MODULES_DELETE', 'Delete Config module'],
        ['CONFIG_MODULES_DELETE', 'Delete Config module'],
        ['CONFIG_MODULES_OPTIONS', 'View Config module options'],
        ['CONFIG_MODULES_OPTION_CREATE', 'Create Config module option'],
        ['CONFIG_MODULES_OPTION_UPDATE', 'Update Config module option'],
        ['CONFIG_MODULES_OPTION_DELETE', 'Delete Config module option'],


    ];

    public $roles = [
        ['CONFIG_ADMIN', '"Config" Administrator', [
            'CONFIG_MODULES_INDEX',
            'CONFIG_MODULES_VIEW',
            'CONFIG_MODULES_CREATE',
            'CONFIG_MODULES_UPDATE',
            'CONFIG_MODULES_DELETE',
            'CONFIG_MODULES_OPTIONS',
            'CONFIG_MODULES_OPTION_CREATE',
            'CONFIG_MODULES_OPTION_UPDATE',
            'CONFIG_MODULES_OPTION_DELETE',
        ]],
        ['CONFIG_MANAGER', '"Config"" Manager', [
            'CONFIG_MODULES_INDEX',
            'CONFIG_MODULES_VIEW',
            'CONFIG_MODULES_OPTIONS',
            'CONFIG_MODULES_OPTION_UPDATE',
        ]]
    ];

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function up()
    {
        //$this->removeAllAuthItems();
        $this->registerRules();
        $this->registerPermissions();
        $this->registerRoles();
    }

    /**
     * @throws Exception
     */
    public function registerPermissions()
    {
        $auth = Yii::$app->authManager;

        foreach ($this->permissions as $permission) {

            $p = $auth->createPermission($permission[0]);
            $p->description = $permission[1];
            if (isset($permission[2])) {
                foreach ($permission[2] as $ruleName) {
                    $p->ruleName = $ruleName;
                }
            }
            $auth->remove($p);
            $auth->add($p);
        }


    }

    /**
     * @throws Exception
     */
    public function registerRoles()
    {
        $auth = Yii::$app->authManager;

        foreach ($this->roles as $role) {
            $r = $auth->createRole($role[0]);
            $r->description = $role[1];
            $auth->remove($r);
            $auth->add($r);
            if (isset($role[2])) {
                foreach ($role[2] as $permissionName) {
                    $permission = $auth->getPermission($permissionName);
                    $auth->addChild($r, $permission);
                }
            }

        }
    }


    /**
     * @throws Exception
     */
    public function registerRules()
    {
        $auth = Yii::$app->authManager;

        foreach ($this->rules as $key => $rule) {
            $r = new $rule();
            $auth->remove($r);
            $auth->add($r);
        }
    }

    /**
     * @throws Exception
     */
    public function removeAllAuthItems()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {

    }
}
