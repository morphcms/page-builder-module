<?php

namespace Modules\PageBuilder\Enum;

use Modules\Morphling\Enums\HasSelectOptions;
use Modules\Morphling\Enums\HasValues;

enum ContentStatus: string
{
    use HasValues, HasSelectOptions;

    case Draft = 'draft';
    case Review = 'review';
    case Published = 'published';

    public static function getNovaBadgeColors(): array
    {
        return [
            ContentStatus::Published->value => 'success',
            ContentStatus::Review->value => 'warning',
            ContentStatus::Draft->value => 'info',
        ];
    }
}
