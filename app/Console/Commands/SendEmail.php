<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:ploc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email notifier for product left on cart';

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
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $data = array (
            'name' => "xxx"
       );

        Mail::send('emails.test', $data, function ($message) {

            $message->from('xxx@gmail.com');

            $message->to('xxx@gmail.com')->subject('xxx');

        });
        $this->info('The emails are send successfully!');
    }
}
