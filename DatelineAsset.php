<?php
/**
 * MIT licence
 * Version 2.0.0
 * Sjaak Priester, Amsterdam 05-07-2015... 15-08-2019.
 *
 * Widget for date related data in Yii 2.0 framework
 */

namespace sjaakp\dateline;

use yii\web\AssetBundle;

class DatelineAsset extends AssetBundle {

    public $baseUrl = '//unpkg.com/@sjaakp/dateline/dist';

    public $css = [
        'dateline.css'
    ];

    public $js = [
        'dateline.js'
    ];
}
