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
      action="<?=$arParams["ACTION"]?>"
      method="post"
      role="form">




    <?foreach ($arResult["FILDS"] as $id=>$arField):?>

        <div class="form-group">
            <label for="feedback-<?=$id?>" class="col-sm-4 control-label"><?=$arField["title"]?></label>
            <div class="col-sm-7">
                <?if($arField["data_type"] == "text"):?>
                    <textarea class="form-control"
                              id="feedback-<?=$id?>"
                              name="feedback-<?=$id?>"
                              rows="3"><?=$arField["value"]?></textarea>
                <?else:?>
                    <input type="text"
                           class="form-control"
                           id="feedback-<?=$id?>"
                           name="feedback-<?=$id?>"
                           value="<?=$arField["value"]?>" />
                <?endif;?>
            </div>
        </div>


    <?endforeach;?>



    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-10">
            <input type="submit"
                   class="btn btn-danger"
                   value="<?=Loc::getMessage("FEEDBACK_SUBMIT")?>">
        </div>
    </div>

</form>

