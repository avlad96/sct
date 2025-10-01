<?php

namespace App\Models;

use Database\Factories\BuildingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Builder;
use Laravel\Scout\Searchable;
use Meilisearch\Endpoints\Indexes;

class Building extends Model
{
    /** @use HasFactory<BuildingFactory> */
    use HasFactory, Searchable;

    protected $fillable = [
        'address',
        'lat',
        'lon',
    ];

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            '_geo' => [
                'lat' => $this->lat,
                'lng' => $this->lon,
            ],
        ];
    }

    public static function searchByRadius(float $lat, float $lon, int $radius): Builder
    {
        return self::search(
            '',
            function (Indexes $meilisearch, string $query, array $options) use ($lat, $lon, $radius) {
                $options['filter'] = "_geoRadius($lat, $lon, $radius)";

                return $meilisearch->search($query, $options);
            }
        );
    }
}
