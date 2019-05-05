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
 * @var array $arParams
 * @var array $arResult
 * @param CMatrixComponent $this
 */
?>
<div class="container margin-top-10 padding-top-10 padding-bottom-10 thumbnail" id="personal">
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">

            <?$APPLICATION->IncludeComponent("matrix:menu", "personal", array(
                "ACTIVE_DIR" => $APPLICATION->GetCurDir(),
                "CURRENT_DIR" => "/personal/",
                "COMPONENT_TEMPLATE" => "",
                "ROOT_MENU_TYPE" => "personal",
                "MENU_CACHE_TYPE" => "N",
                "MENU_CACHE_TIME" => "360000000",
                "MENU_CACHE_USE_GROUPS" => "N",
                "MENU_CACHE_GET_VARS" => array(
                ),
                "MAX_LEVEL" => "1",
                "CHILD_MENU_TYPE" => "personal",
                "USE_EXT" => "N",
                "DELAY" => "N",
                "ALLOW_MULTI_SELECT" => "N"
            ))?>

        </div>
        <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">



            Add new post





        </div>
    </div>
</div>
