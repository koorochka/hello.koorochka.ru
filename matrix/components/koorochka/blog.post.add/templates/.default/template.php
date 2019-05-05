<?
/**
 * Matrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @global CUserTypeManager $USER_FIELD_MANAGER
 * @var array $arParams
 * @var array $arResult
 * @var CMatrixComponent $this
 */

use Matrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->addExternalJS(SITE_TEMPLATE_PATH . "/js/text.editor.js");
?>


<form class="form-horizontal"
      action="<?=$arParams["ACTION"]?>"
      method="post"
      role="form">
    <?=matrix_sessid_post()?>

    <div class="form-group">
        <label for="post_name" class="col-sm-3 control-label">Имя</label>
        <div class="col-sm-8">
            <input type="text"
                   class="form-control"
                   id="post_name"
                   name="post_name"
                   value="test"
                   placeholder="name">
        </div>
    </div>

    <div class="form-group">
        <label for="post_message"
               class="col-sm-3 control-label">Сообщение</label>
        <div class="col-sm-8">

            <div class="btn-group">
                <div class="btn btn-default" onclick="textEditor.setIcon('text-editor', 'apple')"><i class="glyphicon glyphicon-apple"></i></div>
                <div class="btn btn-default" onclick="textEditor.setIcon('text-editor', 'plus')"><i class="glyphicon glyphicon-plus"></i></div>
                <div class="btn btn-default" onclick="textEditor.setIcon('text-editor', 'euro')"><i class="glyphicon glyphicon-euro"></i></div>
                <div class="btn btn-default" onclick="textEditor.setIcon('text-editor', 'camera')"><i class="glyphicon glyphicon-camera"></i></div>
            </div>

            <div contenteditable="true"
                 id="text-editor"
                 onkeydown="textEditor.keydown(this)"
                 onkeyup="textEditor.keyup(this)"
                 onkeypress="textEditor.keypress(this)"
                 class="alert alert-warning">
                some text <i class="glyphicon glyphicon-apple"></i> some text
            </div>


            <textarea class="form-control"
                      id="post_message"
                      name="post_message"
                      rows="3">some text <i class="glyphicon glyphicon-apple"></i> some text</textarea>




        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <input type="submit"
                   class="btn btn-danger"
                   value="Отправить">
        </div>
    </div>
</form>