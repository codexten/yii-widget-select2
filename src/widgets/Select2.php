<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 6/3/19
 * Time: 2:26 PM
 */

namespace codexten\yii\widgets;


use yii\helpers\Url;
use yii\web\JsExpression;

class Select2 extends \kartik\select2\Select2
{
    public $placeholder = '';
    public $initValue = '';
    public $url = false;
    public $data = null;
    public $idField = 'id';
    public $textField = 'name';
    public $allowClear = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->normalize();
        parent::init();
    }

    /**
     * Normalizing configuration
     */
    public function normalize()
    {
        if ($this->placeholder !== null) {
            $this->pluginOptions['placeholder'] = $this->placeholder;
        }

        if ($this->initValue) {
            $this->initValueText = $this->initValue;
        }

        if ($this->url) {
            $this->pluginOptions['ajax']['url'] = Url::to($this->url);
            $this->pluginOptions['ajax']['processResults'] = new JsExpression($this->processResults());
        }
        if (!isset($this->pluginOptions['allowClear'])) {
            $this->pluginOptions['allowClear'] = $this->allowClear;
        }
    }

    protected function processResults()
    {
        return <<<JS
function (data, params) {
var arrayLength = data.length;
var items = [];
for (var i = 0; i < arrayLength; i++) {
    var item = data[i];
  
    items.push({
        'id' : item['{$this->idField}'],
     'text' : item['{$this->textField}'] 
    });
}
    return {
        results: items
    };
}
JS;

    }
}
