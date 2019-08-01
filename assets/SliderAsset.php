<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Description of SliderAsset
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 */
class SliderAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'jasco/slider/responsiveslides.css',
    ];
    public $js = [
        'jasco/slider/responsiveslides.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}