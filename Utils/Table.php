<?php

namespace Modules\PageBuilder\Utils;

use Modules\Morphling\Traits\TableHelper;

/**
 * @method static contents()
 * @method static blocks()
 *
 */
class Table
{
    use TableHelper;

    public static string $configPath = 'page-builder.table_prefix';


}
