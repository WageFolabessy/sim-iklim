<?php

namespace App\Models;

use App\Enums\AnomalyType;
use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['reporter_name', 'location', 'anomaly_type', 'description', 'status'])]
class CitizenReport extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'anomaly_type' => AnomalyType::class,
            'status' => ReportStatus::class,
        ];
    }
}
