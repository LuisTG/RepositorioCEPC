<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\Categoria;
use dosamigos\ckeditor\CKEditor;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(['id'=>'dynamic-form',
        'enableAjaxValidation'=>true,
        'validationUrl'=>Url::toRoute('post/validation')]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    
    
    <?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'problem_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'problem_link')->textInput(['maxlength' => true]) ?>

    
    <div class="rows">
        <div class="thumbnail">
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsPoItem[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'id_categoria',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelsPoItem as $i => $modelPoItem): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Categoria</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelPoItem->isNewRecord) {
                                echo Html::activeHiddenInput($modelPoItem, "[{$i}]id");
                            }
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelPoItem, "[{$i}]id_categoria")->dropDownList(
                                    ArrayHelper::map(Categoria::find(['attribute'=>'nombre'])->orderBy(['nombre'=>SORT_ASC])->all(),'id','nombre'),['prompt'=>'Selecciona una categoría']
                                ) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>




