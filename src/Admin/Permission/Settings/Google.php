<?php

namespace Nails\Analytics\Driver\Google\Admin\Permission\Settings;

use Nails\Admin\Interfaces\Permission;

class Google implements Permission
{
    public function label(): string
    {
        return 'Can manage Google Analytics settings';
    }

    public function group(): string
    {
        return 'Settings';
    }
}
