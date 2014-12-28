<?php
$pageDataSet = isset($pageData);
if ($pageDataSet === false) {
    trigger_error('Oops: view/page-template-html.php needs a PageData object $pageData.');
}

return "
<!DOCTYPE html>
<!--[if IE 9]><html class='lt-ie10' lang='en' > <![endif]-->
<html class='no-js' lang='en'>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
{$pageData->getCss()}
<title>{$pageData->getTitle()}</title>
{$pageData->getScriptCodeHead()}
</head>
<body class='{$pageData->getBodyClass()}'>
    <!-- nav here -->
    {$pageData->getNav()}

    <!-- content here -->
    {$pageData->getContent()}
    
    <!-- footer here -->
    {$pageData->getFooter()}
    
    <!-- scripts here -->
    {$pageData->getJs()}
    {$pageData->getScriptCode()}
</body>
</html>";
