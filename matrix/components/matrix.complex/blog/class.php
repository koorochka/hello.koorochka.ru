<?
use Matrix\Main\Context;
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();
if(class_exists("MatrixPersonal"))
    return;

/**
 * Class MatrixPersonal
 */
class MatrixPersonal extends CMatrixComponent
{
    private $_componentPage;

    /**
     * parse url to array
     * @param mixed $componentPage
     */
    public function setComponentPage()
    {
       $componentPage = "list";
       $this->_componentPage = $componentPage;
    }

    /**
     * Check componentPage element 2
     * @return mixed
     */
    public function getComponentPage()
    {
        return $this->_componentPage;
    }

    /**
     * Execution
     */
    public function executeComponent()
    {
        $this->setComponentPage();
        $this->IncludeComponentTemplate($this->getComponentPage());
    }
}
