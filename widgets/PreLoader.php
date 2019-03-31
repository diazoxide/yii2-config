<?php
/**
 * Created by PhpStorm.
 * User: Yordanyan
 * Date: 30.03
 * Time: 22:30
 */

namespace diazoxide\yii2config\widgets;


use kartik\spinner\Spinner;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class PreLoader extends Widget
{

    public $options = ['tag' => 'div'];

    public $delay = 100;
    public function init()
    {
        $this->options['id'] = 'preloader_' . $this->id;
        $this->registerStyle();
        $this->registerScript();
    }

    /**
     * @return string|void
     * @throws \Exception
     */
    public function run()
    {

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'div');

        echo Html::beginTag($tag, $options);

        echo Spinner::widget([
            'preset' => Spinner::LARGE,
            'color' => 'white',
            'align' => 'center',
            'options' => ['class' => 'status']
        ]);

        echo Html::endTag($tag);
    }

    public function registerStyle()
    {
        $style = <<<STYLE
#{$this->options['id']} {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #111;
    width:100%;
    height:100%;
    z-index: 999999;  
}
#{$this->options['id']} .status {
    position: absolute;
    left: 50%;
    top: 50%;
}
STYLE;

        $this->view->registerCss($style);

    }

    public function registerScript()
    {
        $js = <<<SCRIPT
;(function(window, $) {
    $(document).ready(function() { 
      $('#{$this->options['id']} .status').fadeOut(); 
      $('#{$this->options['id']}').delay({$this->delay}).fadeOut('slow'); 
      $('body').delay({$this->delay}).css({'overflow':'auto'});
    })
})(window, jQuery)
SCRIPT;
        $this->view->registerJs($js);

    }
}