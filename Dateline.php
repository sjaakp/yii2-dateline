<?php
/**
 * MIT licence
 * Version 1.0.0
 * Sjaak Priester, Amsterdam 05-07-2015.
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
     * @var int | string | false
     * Height of the dateline.
     * - int        height in pixels
     * - string     valid CSS height (f.i. in ems)
     * - false      height is not set; caution: the height MUST be set by some other means (CSS), otherwise
     *              the dateline will not appear.
     */
    public $height = 200;

    /**
     * @var bool
     * - false      clicking on an event in Compact layout opens a bubble window with information obtained by
     *              a Java GET-call to $url
     * - true       clicking redirects the browser to $url
     */
    public $redirect = false;

    /**
     * @var string
     * URL of the click action on an Event in Compact layout. The URL is supplemented by '?id=<id>'
     * If not set, there is no click action.
     */
    public $url;

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

        $options = [
            'size' => $this->height,
            'bands' => $this->bands,
            'events' => $tData,
            'redirect' => $this->redirect,
            'url' => $this->url
        ];

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
