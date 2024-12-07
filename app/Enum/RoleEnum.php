<?php

namespace App\Enum;

enum RoleEnum: string
{
    case Admin = 'admin';
    case Librarian = 'librarian';
    case Member = 'member';
}
