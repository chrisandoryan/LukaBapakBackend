<?php

namespace App\Exports;

use App\CartDetail;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Resources\CartResource;

class CartExport implements FromCollection
{
    protected $user;
    public function headings(): array
    {
        return [
            '#',
            'Date',
        ];
    }
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CartDetail::where('user_uuid', $this->user->uuid)->get();
    }
}
