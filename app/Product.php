<?php

namespace App;

use App\CartDetail;
use App\DetailFavorite;
use App\DetailPromotion;
use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;
use \JordanMiguel\LaravelPopular\Traits\Visitable;

class Product extends Model
{
    use ElasticquentTrait;
    use Visitable;

    protected $primaryKey = 'uuid'; //before uuid
    public $incrementing = false;
    public $timestamps = false;
    public $table = 'products';

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::uuid4();
        });
    }

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
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function category()
    {
        // return $this->belongsTo(Category::class, 'category_id', 'id');
        return $this->belongsTo(Category::class, 'category_uuid', 'uuid');
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
