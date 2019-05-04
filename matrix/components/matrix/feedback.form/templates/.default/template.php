<?
/**
 * Matrix Framework
 * @package matrix
 * @subpackage main
 * @copyright 2017 Matrix
 * Matrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @global CUserTypeManager $USER_FIELD_MANAGER
 * @param array $arParams
 * @param array $arResult
 * @param CMatrixComponent $this
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<form class="form-horizontal" role="form">
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-3 control-label">Имя</label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
        <div class="col-sm-9">
            <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-3 control-label">Телефон</label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-3 control-label">Сообщение</label>
        <div class="col-sm-8">
            <textarea class="form-control" rows="3"></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Отправить</button>
        </div>
    </div>
</form>