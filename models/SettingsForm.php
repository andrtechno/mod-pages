<?php

namespace panix\pages\models;

use panix\engine\SettingsModel;

class SettingsForm extends SettingsModel {

    protected $category = 'pages';
    protected $module = 'pages';
    public $pagenum;

    public function rules() {
        return [
            [['pagenum'], "required"],
        ];
    }

}