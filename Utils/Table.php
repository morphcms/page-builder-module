<?php

namespace Modules\PageBuilder\Utils;

class Table
{
    protected static function prefix($table): string
    {
        return Table.phpconfig('page-builder.table_prefix');
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
