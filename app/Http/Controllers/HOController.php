<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Image;
use App\Category;
use App\Product;

use GuzzleHttp\Client;

class HOController extends Controller
{
    /*
     * This is a controller, adding this to a route endpoint is required.
     * 
     * Pre-script Query: query that might have to be run to obtain the correct table structure.
     * To do:
     * 0. backup the original database !important
     * 1. configure $fillable for every Model
     * 2. restructure the tables
     * 3. php artisan serve
     * 4. visit the route endpoint
     * 
     * Dependencies:
     * GuzzleHttp (used on RajaOngkir Data Clone)
     * ramsey/uuid (as UUID generator)
     * 
     * */
    protected $rajaOngkirUrl = "https://api.rajaongkir.com/starter/";
    private $rajaOngkirApiKey = "";

    //Terimakasih ko HO
    public function convertHODBToUsefulDB()
    {
        error_log("Started table migration");
        $sourceUsers = User::limit(10001)->get();
        // Pre-script Query*: create table new_users select * from users limit 0; 
        /* step 1: migrate users table */
        $x = 0;
        foreach ($sourceUsers as $user) {
            $usuuid = Uuid::uuid4();
            error_log($x++ . " Generating UUID " . $usuuid . " for a user with id " . $user->uuid);
            DB::table('new_users')->insert([
                'uuid' => $usuuid,
                'username' => $user->username,
                'name' => $user->name,
                'phone' => '081234567890',
                'email' => 'test@gmail.com',
                'password' => $user->password,
                'gender' => 'male',
                'city_id' => 447,
                'address' => 'BLI, Sentul City, Jalan Pakuan No.3, Sumur Batu, Babakan Madang, Sumur Batu, Babakan Madang, Bogor, Jawa Barat 16143',
                'avatar_url' => $user->avatar_url,
                'avatar_filename' => $user->avatar_filename,
                'verified' => 1,
                'positive_feedback' => $user->positive_feedback,
                'negative_feedback' => $user->negative_feedback,
            ]);
            // Pre-script Query*: alter table products add column user_uuid varchar(40) after user_id;
            $products = Product::where('user_id', $user->uuid)->get();
            foreach ($products as $product) {
                error_log('updating product with owner id: ' . $user->uuid);
                $product->user_uuid = $usuuid;
                $product->update([
                    'user_uuid' => $usuuid
                ]);
                $product->save();
            }
        }

        $categories = Category::all();
        // Pre-script Query*: create table new_categories select * from categories limit 0; 
        /* step 2: migrate categories table and update table products into table with uuid */
        foreach ($categories as $c) {
            $uuid = Uuid::uuid4();
            error_log("Generating uuid: " . $uuid . " for parent category: " . $c->name);
            error_log("Updating related child(ren) category and the product with new parent_uuid: " . $uuid);
            // pseudo step 2
            if ($c->uuid == null) {
                $c->uuid = $uuid;
                $c->save();
                error_log('Success updating uuid of ' . $c->name . ' into: ' . $c->uuid);
            }
            // pseudo step 3
            if ($c->parent_id == null) {
                error_log('Found parent category: ' . $c->name);
                $c->parent_uuid = null;
                $c->save();
            }
            // pseudo step 4
            else {
                $parent = $c->parent;
                error_log('Found child category of parent: ' . $parent->name);
                $c->parent_uuid = $parent->uuid;
                $c->save();
            }
            
            $products = Product::where('category_id', $c->id)->get();
            
            foreach ($products as $p) {
                error_log('Updating product: ' . $p->name . 'with category uuid: ' . $c->uuid);
                $p->category_uuid = $c->uuid;
                $p->save();
            }

            $c->products()->update([
                'category_uuid' => $uuid,
            ]);

            error_log('updated related product into: ' . $uuid);

            $c->save();
        }
        $sourceProducts = Product::limit(16500)->get();
        //Pre-script Query*: alter table images add column product_uuid varchar(40);
        /* step 4: update product id and its relation into using uuid */
        $i = 0;
        foreach ($sourceProducts as $product) {
            $puuid = Uuid::uuid4();
            error_log($i++ . " Generating uuid: " . $puuid . " on a product with id: " . $product->id);
            $product->uuid = $puuid;
            $product->save();
            $images = Image::where('product_id', $product->id)->get();
            foreach($images as $img) {
                error_log("Updating image: " . $img->filename . " with product uuid as: " . $puuid);
                $img->product_uuid = $puuid;
                $img->save();
            }
            $product->images()->update([
                'product_uuid' => $puuid
            ]);
        }
        error_log("Finished");

        // Post-script query*: (run this to clean the table from garbage data if neccessary)
        // delete from images where product_uuid is null;
        // delete from products where uuid is null;
    }

    public function saveRajaOngkirData()
    {
        $client = new Client();
        $provinces = $client->request('GET', $this->rajaOngkirUrl . "province", [
            'query' => [
                'key' => $this->rajaOngkirApiKey,
            ]
        ]);
        $provinces = json_decode($provinces->getBody(), true)['rajaongkir']['results'];
        // echo "Inserting provinces... ";
        foreach ($provinces as $key => $value) {
            // var_dump($value);
            DB::table('provinces')->insert([
                'id' => $value['province_id'],
                'province_name' => $value['province'],
                'created_at' => now(),
            ]);
            $cities = $client->request('GET', $this->rajaOngkirUrl . "city", [
                'query' => [
                    'key' => $this->rajaOngkirApiKey,
                    'province' => $value['province_id']
                ]
            ]);
            $cities = json_decode($cities->getBody(), true)['rajaongkir']['results'];
            // echo "Inserting cities... ";
            foreach ($cities as $alsoKey => $alsoValue) {
                // var_dump($alsoValue['city_name']);
                DB::table('cities')->insert([
                    'province_id' => $value['province_id'],
                    'type' => $alsoValue['type'],
                    'city_name' => $alsoValue['city_name'],
                    'created_at' => now(),
                ]);
            }
            echo "OK ";
        }
    }
}

// Users Table
// Changes*:
// (-) id int
// (+) uuid varchar(40)
//
// +-------------------+------------------+
// | Field             | Type             |
// +-------------------+------------------+
// | uuid PK           | varchar(40)      |
// | username          | varchar(255)     |
// | name              | varchar(255)     |
// | phone             | varchar(128)     |
// | email             | varchar(128)     |
// | password          | varchar(255)     |
// | gender            | char(10)         |
// | city_id           | int(10) unsigned |
// | address           | varchar(255)     |
// | avatar_url        | varchar(255)     |
// | avatar_filename   | varchar(255)     |
// | positive_feedback | int(11)          |
// | negative_feedback | int(11)          |
// | verified          | smallint(6)      |
// | updated_at        | timestamp        |
// | created_at        | date             |
// +-------------------+------------------+

// Products Table
// Changes*: 
// (+) uuid varchar(40)
// (+) category_uuid varchar(40)
// (+) user_uuid varchar(40)
//
// +-------------------+--------------+
// | Field             | Type         |
// +-------------------+--------------+
// | id  PK            | int(11)      |
// | uuid              | varchar(40)  |
// | category_id       | int(11)      |
// | category_uuid     | varchar(40)  |
// | user_id           | int(11)      |
// | user_uuid         | varchar(40)  |
// | sold_count        | int(11)      |
// | video_url         | varchar(255) |
// | assurance         | tinyint(4)   |
// | bl_id             | varchar(255) |
// | url               | varchar(255) |
// | name              | varchar(255) |
// | city              | varchar(255) |
// | province          | varchar(255) |
// | price             | int(11)      |
// | weight            | int(11)      |
// | description       | text         |
// | product_condition | varchar(20)  |
// | stock             | int(11)      |
// | view_count        | int(11)      |
// | created_at        | timestamp    |
// +-------------------+--------------+

// Categories Table
// Changes*:
// (+) uuid varchar(40)
// (+) parent_uuid varchar(40)
// 
// +-------------+--------------+
// | Field       | Type         |
// +-------------+--------------+
// | id PK       | int(11)      |
// | parent_id   | int(11)      |
// | uuid        | varchar(40)  |
// | parent_uuid | varchar(40)  |
// | name        | varchar(255) |
// +-------------+--------------+

//*the term "Changes" is the structure changes to the one and only, the original, majestic, amazing, splendid, magnificent, ko HO's Bukalapak Database.