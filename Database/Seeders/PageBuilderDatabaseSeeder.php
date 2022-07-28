<?php

namespace Modules\PageBuilder\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Acl\Utils\AclSeederHelper;
use Modules\PageBuilder\Enum\ContentPermission;

class PageBuilderDatabaseSeeder extends Seeder
{
    use AclSeederHelper;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->acl('page-builder')
            ->attachEnum(ContentPermission::class, ContentPermission::All->value)
            ->create();
    }
}
