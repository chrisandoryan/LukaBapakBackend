<?php

namespace App;

use App\CartDetail;
use App\DetailFavorite;
use App\DetailPromotion;
use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;

class Product extends Model
{
    use ElasticquentTrait;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['uuid', 'category_uuid', 'user_uuid'];
    //

    protected $mappingProperties = array(
        'name' => [
            'type' => 'text',
            "analyzer" => "standard",
        ],
        'description' => [
            'type' => 'text',
            "analyzer" => "standard",
        ],
        'product_condition' => [
            'type' => 'text',
            "analyzer" => "standard",
        ],
    );

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class);
    }

    public function detailFavorites()
    {
        return $this->hasMany(DetailFavorite::class);
    }

    public function detailPromotions()
    {
        return $this->hasMany(DetailPromotion::class);
    }

}
