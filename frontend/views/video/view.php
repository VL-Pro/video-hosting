<?php
/**
 * Created by PhpStorm.
 * User: pvp
 * Date: 2/17/2017
 * Time: 12:45 PM
 */

use yii\helpers\Html;

/* @var $model \common\models\Video */
/* @var $section \common\models\Section */
/* @var $topic \common\models\Topic */


$script = <<<JS
    $(document).ready(function() {
        $('span#favorites').click(function(){
            addSubscription();
        });     
    });
 
    function addSubscription(){
        
        var video_id = $("#video_id").attr("data-id");
         
        $.ajax({
            type: "POST",
            url: "favorites",
            data: {
                'video_id': video_id
            },
            dataType: "json",
            
            success: function(data){
                if(data.result == 'success'){   
                    $("#favorites").html(data.msg);
                }else{
                    alert(data.msg);
                }
            }
        });
    }
JS;

$this->registerJs($script, yii\web\view::POS_READY);

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $section->name, 'url' => ['/section/view', 'id' => $section->id]];
$this->params['breadcrumbs'][] = ['label' => $topic->name, 'url' => ['/topic/view', 'id' => $topic->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <div class="row">
        <div class="col-lg-12">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="video-item col-md-8 col-md-offset-2">
            <video class="video-block" controls>
                <source id="video_id" src = "<?= \common\models\Video::getParentFolderLink().$model->path;?>" data-id = "<?= $model->id ?>" type='video/mp4'>
            </video>
            <p><?= $model->description ?></p>
        </div>
        <div class="col-md-2">
            <p><span id="favorites" class="text-center"><?= $favorites_msg ?></span></p>
        </div>
    </div>
</div>