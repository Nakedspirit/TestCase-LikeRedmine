<?php
/**
 * Created by PhpStorm.
 * User: Galinka
 * Date: 05.02.2018
 * Time: 0:31
 */

use TestCase\app\components\AdminBase;
include 'template/header.php';

?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-push-4 col-md-4" style="text-align: center">
                <div class="">
                    <!--sign up form-->
                    <h1>Вход в админку</h1>
                    <form action="#" method="post">
                    <?php if(!AdminBase::checkAdmin()){?>
                        <div class="form-group">
                        <input class="form-control"  type="text" name="username" placeholder="admin" value=""/>
                        </div>
                        <div class="form-group">
                        <input class="form-control"  type="password" name="password" placeholder="123" value=""/>
                        </div>
                        <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-default" value="Вход" />
                        </div>
                    <?php }else{?>
                        <p>Вы уже вошли как администратор</p>
                        <input type="submit" name="submit" class="btn btn-default" value="Выход" />
                    <?php }?>
                    </form>
                </div>
                <!--/sign up form-->
            </div>
        </div>
    </div>
</section>
