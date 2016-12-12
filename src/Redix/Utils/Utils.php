<?php

namespace Redix\Utils;

use Redix\Config\Config;

class Utils
{
    const MIGRATION_FILE_NAME_PATTERN = '/\d+_([\w_]+).php$/i';

    public static function isFileUnique($path)
    {
        $files = glob($path);

        return !count($files);
    }

    public static function mapFileNameToClassName($fileName)
    {
        $matches = array();
        if (preg_match(static::MIGRATION_FILE_NAME_PATTERN, $fileName, $matches)) {
            $fileName = $matches[1];
        }
        return str_replace(' ', '', ucwords(strtolower(str_replace('_', ' ', $fileName))));
    }
}
