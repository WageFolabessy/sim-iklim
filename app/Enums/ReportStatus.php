<?php

namespace App\Enums;

enum ReportStatus: string
{
    case Pending = 'pending';
    case Published = 'published';
    case Rejected = 'rejected';
}
