<?php 
$cs = Yii::app()->getClientScript();

$cs->registerCssFile(Yii::app()->getModule('githubs')->assetsUrl."/bootstrap-wysihtml5/lib/css/bootstrap.min.css");
$cs->registerCssFile(Yii::app()->getModule('githubs')->assetsUrl."/bootstrap-wysihtml5/src/bootstrap-wysihtml5.css");
$cs->registerCssFile(Yii::app()->getModule('githubs')->assetsUrl."/bootstrap-wysihtml5/lib/css/wysiwyg-color.css");
$cs->registerScriptFile(Yii::app()->getModule('githubs')->assetsUrl."/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.js" , CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->getModule('githubs')->assetsUrl."/bootstrap-wysihtml5/lib/js/jquery-1.7.2.min.js" , CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->getModule('githubs')->assetsUrl."/bootstrap-wysihtml5/lib/js/bootstrap.min.js" , CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->getModule('githubs')->assetsUrl."/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js" , CClientScript::POS_HEAD);
?>
<input type="text" value="" name="title" id="title">
<textarea class="textarea" placeholder="Enter text ..." style="width: 810px; height: 200px"></textarea>

<ul data-role="listview" data-editable="true" data-editable-type="complex" data-editable-form="editing-form" data-title="Fruits" data-empty-title="No Fruits">
<li>
    <a>
        <h3>Apple</h3>
        <p><em>Shape:</em> <strong>round</strong></p>
        <p><em>Color:</em> <strong>red</strong></p>
    </a>
</li>
<li>
    <a>
        <h3>Pineapple</h3>
        <p><em>Shape:</em> <strong>oval</strong></p>
        <p><em>Color:</em> <strong>yellow</strong></p>
    </a>
</li>
<li>
    <a>
        <h3>Orange</h3>
        <p><em>Shape:</em> <strong>round</strong></p>
        <p><em>Color:</em> <strong>orange</strong></p>
    </a>
</li>
</ul>

<script>
	$('.textarea').wysihtml5();
</script>