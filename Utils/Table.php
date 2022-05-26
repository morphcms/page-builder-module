<?php

namespace Modules\PageBuilder\Utils;

class Table
{
    protected static function prefix($table): string
    {
        return config('page-builder.table_prefix') . $table;
    }


    public static function blocks(): string
    {
        return static::prefix('blocks');
    }

    public static function contents(): string
    {
        return static::prefix('contents');
    }
}
