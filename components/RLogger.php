<?php


namespace app\components;


class RLogger
{
    public static function debug($where, $text) {
        $fileName = 'debug.log';
        $filePath = __DIR__ . DIRECTORY_SEPARATOR . '../temp' . DIRECTORY_SEPARATOR .  $fileName;

        $str = '[ ' . date('Y-m-d H:i:s') . ' ]' . ' { ' . $where . ' } ' . $text . PHP_EOL;
        file_put_contents($filePath, $str, FILE_APPEND | LOCK_EX);
    }

    public static function debugVarDump($where, $arr) {
        ob_start();
        var_dump($arr);
        $result = ob_get_clean();
        self::debug($where, $result);
    }
}