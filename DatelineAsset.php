<?php
/**
 * MIT licence
 * Version 1.0.4
 * Sjaak Priester, Amsterdam 05-07-2015.
 *
 * Widget for date related data in Yii 2.0 framework
 */

namespace sjaakp\dateline;

use yii\web\AssetBundle;

class DatelineAsset extends AssetBundle {
    public $depends = [
        'yii\jui\JuiAsset',
    ];

    public $sourcePath = '@bower/dateline';

    public $css = [
        'css/jquery.dateline.css'
    ];

    public $js = [
        '//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js'
    ];

    public $publishOptions = [
        'only' => [ 'css/*.css', 'js/*' ]
    ];

    public function init()    {
        parent::init();

        $this->js[] = YII_DEBUG ? 'js/jquery.dateline.js' : 'js/jquery.dateline.min.js';
    }
}