<?php

namespace App\Enum;

interface UserRoleInterface
{
    public const ROLE_USER_ADMIN = 'Administrator';

    public const ROLE_USER_REGULAR_WORKER = 'Magazynier';

    public const ROLES_USER_MANAGER = 'Kierownik';

    public const USER_ROLES = [
        self::ROLE_USER_ADMIN => 'ROLE_USER_ADMIN',
        self::ROLE_USER_REGULAR_WORKER => 'ROLE_USER_REGULAR_WORKER',
        self::ROLES_USER_MANAGER => 'ROLES_USER_MANAGER',
    ];
}
