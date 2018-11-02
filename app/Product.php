<?php

namespace App;

use App\CartDetail;
use Ramsey\Uuid\Uuid;
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
    // protected $fillable = [‘*’];
    //

    protected $mappingProperties = array(
        'name' => [
            'type' => 'text',
            "analyzer" => "edge_ngram_analyzer",
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
        return $this->hasOne(Image::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function category()
    {
        // return $this->belongsTo(Category::class, 'category_id', 'id');
        return $this->belongsTo(ReverseCategory::class, 'category_uuid', 'uuid'); //in case of eerror change this back to Category::class
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
