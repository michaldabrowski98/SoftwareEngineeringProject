<?php

namespace App\Enum;

enum UserRoleEnum: string
{
    case ROLE_USER_ADMIN = 'ROLE_USER_ADMIN';

    case ROLE_USER_REGULAR_WORKER = 'ROLE_USER_REGULAR_WORKER';

    case ROLES_USER_MANAGER = 'ROLES_USER_MANAGER';
}
