<?php

namespace App\Exports;

use App\CartDetail;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Resources\CartResource;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CartExport implements FromCollection, WithMapping, WithHeadings
{
    protected $user;
    public function map($detail) : array
    {
        return [
            $detail->id,
            $detail->product->name,
            $detail->amount,
            $detail->note,
            $detail->created_at,
        ];
    }
    public function headings() : array
    {
        return [
            'No',
            'Product',
            'Amount',
            'Note',
            'Date'
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
        return CartDetail::where('user_uuid', $this->user->uuid)->with('product')->with('user')->get();
    }
}
