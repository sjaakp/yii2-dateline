<?php
/**
 * MIT licence
 * Version 1.0.1
 * Sjaak Priester, Amsterdam 05-07-2015 ... 01-08-2015.
 *
 * Widget for date related data in Yii 2.0 framework
 */

namespace sjaakp\dateline;

use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Json;


class Dateline extends Widget {

    // Values for band scale
    const MILLISECOND    = 0;
    const SECOND         = 1;
    const MINUTE         = 2;
    const HOUR           = 3;
    const DAY            = 4;
    const WEEK           = 5;
    const MONTH          = 6;
    const YEAR           = 7;
    const DECADE         = 8;
    const CENTURY        = 9;
    const MILLENNIUM     = 10;


    /**
     * @var \yii\data\DataProviderInterface the data provider for the dateline. This property is required.
     */
    public $dataProvider;

    /**
     * @var array key => value pairs of {dateline property name} => {model property name}. Required.
     * Mapping from dateline properties to model properties
     */
    public $attributes;

    /**
     * @var array
     * Client options for the Dateline jQuery widget.
     * @link https://github.com/sjaakp/dateline#cursor
     */
    public $options = [];

    /**
     * @var array
     * HTML options of the dateline container.
     * Use this if you want to explicitly set the ID.
     */
    public $htmlOptions = [];

    protected $bands = [];


    public function init()  {
        if (! $this->dataProvider) {
            throw new InvalidConfigException('The "dataProvider" property must be set.');
        }
        if (! $this->attributes) {
            throw new InvalidConfigException('The "attributes" property must be set.');
        }

        if (isset($this->htmlOptions['id'])) {
            $this->setId($this->htmlOptions['id']);
        }
        else $this->htmlOptions['id'] = $this->getId();
    }


    public function run()   {
        $view = $this->getView();

        $asset = new DatelineAsset();
        $asset->register($view);

        $tData = array_map(function($model) {
            /** @var $model \yii\base\Model */
            $modelAtts = array_filter($model->getAttributes(array_values($this->attributes)), function($att) {
                return ! empty($att);
            });
            $v = [];
            foreach($this->attributes as $tname => $mname)  {
                if (isset($modelAtts[$mname])) $v[$tname] = $modelAtts[$mname];
            }
            return $v;
        }, $this->dataProvider->getModels());

        $options = array_merge ($this->options, [
            'bands' => $this->bands,
            'events' => $tData,
        ]);

        $jOpts = Json::encode($options);

        $id = $this->getId();

        $js = "var {$id}=$('#{$id}').dateline($jOpts);";

        $view->registerJs($js);

        echo Html::tag('div', '', $this->htmlOptions);
    }

    public function band($options)  {
        $this->bands[] = $options;
        return $this;
    }

}
