<?php
/**
 * MIT licence
 * Version 1.0.0
 * Sjaak Priester, Amsterdam 05-07-2015.
 *
 * Widget for date related data in Yii 2.0 framework
 */

namespace sjaakp\dateline;

use yii\web\AssetBundle;

class DatelineAsset extends AssetBundle {
    public $depends = [
        'yii\jui\JuiAsset',
        'madand\underscore\UnderscoreAsset',
    ];

    public $sourcePath = '@bower/dateline/dist';

    public $css = [
        'jquery.dateline.css'
    ];

    public function init()    {
        parent::init();

        $this->js[] = YII_DEBUG ? 'jquery.dateline.js' : 'jquery.dateline.min.js';
    }
}