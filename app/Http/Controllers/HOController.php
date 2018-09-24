<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Category;
use App\Product;

class HOController extends Controller
{
    //Terimakasih ko HO
    public function convertHODBToUsefulDB()
    {
        error_log("Started table migration");
        $sourceUsers = User::limit(1000)->get();
        // required query: create table new_users select * from users limit 0; 
        /* step 1: migrate users table */
        foreach ($sourceUsers as $user) {
            $usuuid = Uuid::uuid4();
            error_log("Generating UUID " . $usuuid . " for a user with id " . $user->uuid);
            DB::table('new_users')->insert([
                'uuid' => $usuuid,
                'username' => $user->username,
                'name' => $user->name,
                'email' => 'test@gmail.com',
                'password' => $user->password,
                'avatar_url' => $user->avatar_url,
                'avatar_filename' => $user->avatar_filename,
                'positive_feedback' => $user->positive_feedback,
                'negative_feedback' => $user->negative_feedback,
            ]);
            // error_log("Updating user_uuid with uuid: " . $usuuid . " on a product with id: " . $user->product->name);
            // required query: alter table products add column user_uuid varchar(40) after user_id;
            $products = Product::where('user_id', $user->uuid)->get();
            foreach ($products as $product) {
                error_log('updating product with owner id: ' . $user->uuid);
                $product->update([
                    'user_uuid' => $usuuid
                ]);
            }
        }

        $sourceParentCategories = Category::where('parent_id', null)->get();
        // required query: create table new_categories select * from categories limit 0; 
        /* step 2: migrate categories table and update table products into table with uuid */
        foreach ($sourceParentCategories as $parent) {
            $uuid = Uuid::uuid4();
            error_log("Generating uuid: " . $uuid . " for parent category with id: " . $parent->id);
            error_log("Updating related child(ren) category and the product with parent_uuid: " . $uuid);
            DB::table('new_categories')->insert([
                'uuid' => $uuid,
                'parent_uuid' => null,
                'name' => $parent->name
            ]);
            foreach ($parent->children as $children) {
                $cuuid = Uuid::uuid4();
                DB::table('new_categories')->insert([
                    'uuid' => $cuuid,
                    'parent_uuid' => $uuid,
                    'name' => $children->name
                ]);
                //required query: alter table products add column category_uuid varchar(40);
                /*step 3: update product id according to category table */
                $children->products()->update([
                    'category_uuid' => $cuuid,
                ]);
            }
        }
        $sourceProducts = Product::limit(10000)->get();
        //required query: alter table images add column product_uuid varchar(40);
        /* step 4: update product id and its relation into using uuid */
        foreach ($sourceProducts as $product) {
            $puuid = Uuid::uuid4();
            error_log("Generating uuid: " . $puuid . " on a product with id: " . $product->id);
            $product->update([
                'uuid' => $puuid
            ]);
            // error_log("Updating product_uuid as: " . $puuid . " on an image with id: " . $product->images->id);
            $product->images()->update([
                'product_uuid' => $puuid
            ]);
        }
        error_log("Finished");
        // Post-script query: 
        // delete from images where product_uuid is null;
        // delete from products where uuid is null;
    }
}
