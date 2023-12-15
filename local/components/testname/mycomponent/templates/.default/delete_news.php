<?php
echo 'DELETE';
echo $_GET['id'];
?>

<?
if(CIBlock::GetPermission($IBLOCK_ID)>='W')
{
    $DB->StartTransaction();
    if(!CIBlockElement::Delete($_GET['id']))
    {
        $strWarning .= 'Error!';
        $DB->Rollback();
    }
    else
        $DB->Commit();
}
?>
