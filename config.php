<?php
namespace tools;

class config
{
    public static function param()
    {
        if (strpos(dirname(__FILE__),'/') !== false) {
            $currentDir = explode('/', dirname(__FILE__));
        } else {
            $currentDir = explode('\\', dirname(__FILE__));
        }
        $documentRoot = explode('/', $_SERVER['DOCUMENT_ROOT']);
        $localDir = implode('/', array_diff($currentDir, $documentRoot));

        $params = [
            'documentRoot' => $_SERVER['DOCUMENT_ROOT'] . '/' . $localDir . '/',
            'rootUrl' => '//:' . $_SERVER['SERVER_NAME'] . '/' . $localDir . '/',
            'toolsDirectory' => dirname(__FILE__) . '/tools/',
            'toolsUrl' => '//:' . $_SERVER['SERVER_NAME'] . '/' . $localDir . '/tools/',
        ];
        return $params;
    }
}
