<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/3/16
 * Time: 上午10:31
 */
use yii\helpers\Html;
?>
<!--评论-->
<div id="comments">
    <h4>共 <span class="text-danger"><?=$model->comment?></span> 条评论</h4>
    <div class="col-4">
        <ul class="media-list">
            <?php foreach ($commentModels as $item):?>
                <li class="media" data-key="<?=$item->id?>">
                    <div class="media-left">
                        <a href="#">
                            <img class="media-object" src="http://www.yiichina.com/uploads/avatar/000/03/21/32_avatar_small.jpg" alt="...">
                        </a>
                    </div>
                    <div class="media-body">
                        <div class="media-heading"><a href=""><?=$item->user->username?></a> 评论于 <?=date('Y-m-d H:i', $item->created_at)?></div>
                        <div class="media-content"><?= $item->content?></div>
                        <?php foreach ($item->sons as $son):?>
                            <div class="media">
                                <div class="media-left">
                                    <a href="/user/index/1.html" rel="author" title=""><img class="media-object" src="http://www.yiichina.com/uploads/avatar/000/03/21/32_avatar_small.jpg" alt=""></a>
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <a href="/user/index/1.html" rel="author" data-original-title="<?=$son->user->username?>" title=""><?=$son->user->username?></a> 回复于 <?=date('Y-m-d H:i', $son->created_at)?>
                                        <span class="pull-right"><a class="reply-btn j_replayAt" href="javascript:;">回复</a></span>
                                    </div>
                                    <div class="media-content"><?= $son->content?></div>
                                </div>
                            </div>
                        <?php endforeach;?>
                        <div class="media-action">
                            <a class="reply-btn" href="#">回复</a><span class="vote"><a class="up" href="<?=\yii\helpers\Url::to(['/vote', 'id' => $item->id, 'type' => 'comment', 'action' => 'up'])?>" title="" data-toggle="tooltip" data-original-title="顶"><span class="fa fa-thumbs-o-up"></span> <em><?=$item->up?></em></a><a class="down" href="<?=\yii\helpers\Url::to(['/vote', 'id' => $item->id, 'type' => 'comment', 'action' => 'down'])?>" title="" data-toggle="tooltip" data-original-title="踩"><span class="fa fa-thumbs-o-down"></span> <em><?=$item->down?></em></a></span>
                        </div>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $commentDataProvider->getPagination()
        ]); ?>
    </div>
</div>
<h4>发表评论</h4>
<?php if (!Yii::$app->user->isGuest): ?>
    <?php $form = \yii\widgets\ActiveForm::begin(['action' => \yii\helpers\Url::toRoute('comment/create')]); ?>
    <?= $form->field($commentModel, 'content')->label(false)->widget('\yidashi\markdown\Markdown', ['options' => ['style' => 'height:200px;']]); ?>
    <?= Html::hiddenInput(Html::getInputName($commentModel, 'article_id'), $model->id) ?>
    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
    <!--回复-->
    <?php $form = \yii\widgets\ActiveForm::begin(['action' => \yii\helpers\Url::toRoute('comment/create'), 'options' => ['class' => 'reply-form hidden']]); ?>
    <?= Html::hiddenInput(Html::getInputName($commentModel, 'article_id'), $model->id) ?>
    <?= Html::hiddenInput(Html::getInputName($commentModel, 'parent_id'), 0, ['class' => 'parent_id']) ?>
    <?=$form->field($commentModel, 'content')->label(false)->textarea()?>
    <div class="form-group">
        <button type="submit" class="btn btn-sm btn-primary">回复</button>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
<?php else: ?>
    <div class="well">您需要登录后才可以评论。<?=Html::a('登录', ['site/login'])?> | <?=Html::a('立即注册', ['site/signup'])?></div>
<?php endif; ?>
