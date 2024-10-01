<?php
namespace App\Enum;

enum CommentStatusEnum: string {
    case PUBLISH = 'public';
    case PENDING = 'pending';
    case REJECT = 'reject';
}
