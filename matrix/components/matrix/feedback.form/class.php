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

if(class_exists("MatrixFeedbackFormComponent"))
    return;

class MatrixFeedbackFormComponent extends CMatrixComponent
{
    // <editor-fold defaultstate="collapsed" desc="# Component params">
    /**
     * @param $arParams
     * @return mixed
     */
	public function onPrepareComponentParams($arParams)
	{
        $arParams["DELAY"] = (isset($arParams["DELAY"]) && $arParams["DELAY"] == "Y" ? "Y" : "N");
		return $arParams;
	}
    // </editor-fold>

    /**
     * Execution
     */
    public function executeComponent()
    {

        /**
         * start work with cache
         */
        if($this->startResultCache(false))
        {

            $this->endResultCache();
        }



        $this->IncludeComponentTemplate();
    }
}