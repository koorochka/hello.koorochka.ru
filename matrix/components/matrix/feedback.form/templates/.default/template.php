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

<form class="form-horizontal" role="form">

    <div class="form-group">
        <label for="feedback-name" class="col-sm-3 control-label"><?=Loc::getMessage("FEEDBACK_NAME")?></label>
        <div class="col-sm-8">
            <input type="text"
                   class="form-control"
                   id="feedback-name"
                   name="name"
                   placeholder="<?=Loc::getMessage("FEEDBACK_NAME_PLACEHOLDER")?>">
        </div>
    </div>

    <div class="form-group">
        <label for="feedback-mail" class="col-sm-3 control-label"><?=Loc::getMessage("FEEDBACK_EMAIL")?></label>
        <div class="col-sm-9">
            <input type="email"
                   class="form-control"
                   id="feedback-mail"
                   name="mail"
                   placeholder="<?=Loc::getMessage("FEEDBACK_EMAIL_PLACEHOLDER")?>">
        </div>
    </div>

    <div class="form-group">
        <label for="feedback-phone" class="col-sm-3 control-label"><?=Loc::getMessage("FEEDBACK_PHONE")?></label>
        <div class="col-sm-8">
            <input type="tel"
                   class="form-control"
                   id="feedback-phone"
                   name="phone"
                   placeholder="<?=Loc::getMessage("FEEDBACK_PHONE_PLACEHOLDER")?>">
        </div>
    </div>

    <div class="form-group">
        <label for="feedback-message" class="col-sm-3 control-label"><?=Loc::getMessage("FEEDBACK_MESSAGE")?></label>
        <div class="col-sm-8">
            <textarea class="form-control"
                      id="feedback-message"
                      name="message"
                      rows="3"></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input type="submit"
                   class="btn btn-danger"
                   value="<?=Loc::getMessage("FEEDBACK_SUBMIT")?>">
        </div>
    </div>
    
</form>