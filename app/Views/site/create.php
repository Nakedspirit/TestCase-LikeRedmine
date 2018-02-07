<?php
/**
 * Created by PhpStorm.
 * User: Galinka
 * Date: 05.02.2018
 * Time: 0:31
 */

use TestCase\app\domain\Task;
include ROOT . '/view/layouts/header.php';
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-push-4 col-md-4">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#panel1">Добавить</a></li>
                <li><a data-toggle="tab" href="#panel2">Предпросмотр</a></li>
            </ul>
            <div class="tab-content">
                <div id="panel1" class="tab-pane fade in active">

                    <h2>Новая задача</h2>
                    <br/>
                    <?php if (isset($errors) && is_array($errors)): ?>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li> - <?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                        <div class="login-form">
                            <form action="#" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label for="pwd">Username:</label>
                                    <input type="text" name="<?=Task::getUsernameDBName()?>" class="form-control" id="pwd">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email address:</label>
                                    <input type="email" name="<?=Task::getEmailDBName()?>" class="form-control" id="email">
                                </div>
                                <div class="form-group">
                                    <label for="comment">Text:</label>
                                    <textarea name="<?=Task::getTextDBName()?>" class="form-control" rows="5" id="comment"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="file">Image:</label>
                                    <input type="file" id="imgInput" class="btn btn-default" name="<?=Task::getImageDBName()?>" placeholder="" value="">
                                </div>
                                <input type="submit" name="submit" class="btn btn-default" class="btn btn-default" value="Сохранить">
                            </form>

                    </div>
                </div>
                <div id="panel2" class="tab-pane fade">
                    <h3>Предпросмотр</h3>
                    <div class=''>
                        <div class='thumbnail'>
                            <img id="imgInput-load" src='<?=MY_SERVER?>/../upload/images/task/img.jpg' alt='...'>
                            <div class='caption'>
                                <p>Статус: <mark>Not Done<mark></p>
                                <blockquote class='blockquote-reverse small'>
                                    <span id="comment-load">{$text}</span>
                                    <footer><span id="pwd-load">{$task->getUsername()}</span> : <span id="email-load">{$task->getEmail()}</span></footer>
                                    <blockquote>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>

