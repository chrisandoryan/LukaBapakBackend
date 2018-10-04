<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CartDetail;
use App\Product;
use Illuminate\Support\Facades\Mail;
use \App\Mail\EmailNotifyCart;

class IngetBeli extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ingetgan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command untuk ingetin user buat beli, biar lukabapak untung';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *$toUpdate = Product::find($id);
     * @return mixed
     */
    public function handle()
    {
        //
        $carts = CartDetail::with('product')->with('product.user')->with('user')->get()->groupBy('user.email');

        foreach ($carts as $key => $value) {

            $data = [
                'resource' => $value,
                'buyer' => $value[0]->user,
                'seller' => $value[0]->product->user
            ];

            // error_log($value);

            Mail::to($key)->send(new EmailNotifyCart($data));
        }

    }
}