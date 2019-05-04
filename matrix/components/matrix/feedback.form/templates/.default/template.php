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

use Matrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<form class="form-horizontal"
      role="form">

    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Ошибка!</strong> Текст ошибки
    </div>

    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Предупреждение!</strong> Текст предупреждения
    </div>

    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Успех!</strong> Успешный текст
    </div>


    <div class="form-group">
        <label for="feedback-name" class="col-sm-4 control-label"><?=Loc::getMessage("FEEDBACK_NAME")?></label>
        <div class="col-sm-7">
            <input type="text"
                   class="form-control"
                   id="feedback-name"
                   name="name"
                   placeholder="<?=Loc::getMessage("FEEDBACK_NAME_PLACEHOLDER")?>">
        </div>
    </div>

    <div class="form-group">
        <label for="feedback-mail" class="col-sm-4 control-label"><?=Loc::getMessage("FEEDBACK_EMAIL")?></label>
        <div class="col-sm-7">
            <input type="email"
                   class="form-control"
                   id="feedback-mail"
                   name="mail"
                   placeholder="<?=Loc::getMessage("FEEDBACK_EMAIL_PLACEHOLDER")?>">
        </div>
    </div>

    <div class="form-group">
        <label for="feedback-phone" class="col-sm-4 control-label"><?=Loc::getMessage("FEEDBACK_PHONE")?></label>
        <div class="col-sm-7">
            <input type="tel"
                   class="form-control"
                   id="feedback-phone"
                   name="phone"
                   placeholder="<?=Loc::getMessage("FEEDBACK_PHONE_PLACEHOLDER")?>">
        </div>
    </div>

    <div class="form-group">
        <label for="feedback-message" class="col-sm-4 control-label"><?=Loc::getMessage("FEEDBACK_MESSAGE")?></label>
        <div class="col-sm-7">
            <textarea class="form-control"
                      id="feedback-message"
                      name="message"
                      placeholder="<?=Loc::getMessage("FEEDBACK_MESSAGE_PLACEHOLDER")?>"
                      rows="3"></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-10">
            <input type="submit"
                   class="btn btn-danger"
                   value="<?=Loc::getMessage("FEEDBACK_SUBMIT")?>">
        </div>
    </div>

</form>