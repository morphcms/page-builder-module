<?php

namespace Modules\PageBuilder\Enum;

use Modules\Morphling\Enums\HasValues;

enum ContentPermission: string
{
    use HasValues;

    case All = 'contents.*';
    case  ViewAny = 'contents.viewAny';
    case  ViewOwned = 'contents.viewOwned';
    case  View = 'contents.view';
    case  Create = 'contents.create';
    case  Update = 'contents.update';
    case  Delete = 'contents.delete';
    case  Replicate = 'contents.replicate';
    case  Restore = 'contents.restore';
}
