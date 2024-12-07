<?php

namespace App\Enum;

enum PermissionEnum: string
{
    case CreateBooks = 'create books';
    case ReadBooks = 'read books';
    case UpdateBooks = 'update books';
    case DeleteBooks = 'delete books';
    case BorrowBooks = 'borrow books';
    case ReturnBooks = 'return books';
}
