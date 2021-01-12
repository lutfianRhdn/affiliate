<?php

namespace App\Exports;

use App\Models\Commission;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;



class CommissionExport implements FromCollection,WithMapping,WithHeadings,ShouldAutoSize,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return filterData('App\Models\Commission');
    }
    public function map($commission) : array {
        $clients = $commission->user->clients;
        $totalClient=[];
        foreach ($clients as $client) {
            foreach ($client->transactions as $transaction ) {
                if (Carbon::parse($transaction->payment_date)->format('m-Y') ==
                    $commission->created_at->format('m-Y')) {
                        array_push($totalClient,$transaction);
                    }
            }
        }
        $totalClient = count($totalClient);
        // \Log::info($totalClient);
        return [
            $commission->id,
            $commission->user->name,
            $commission->product->product_name,
            $commission->user->profile== null ?'null' :$commission->user->profile->account_number,
            $commission->user->profile== null ?'null' :$commission->user->profile->bank_type,
            $commission->status == true ?'paid':'unpaid',
            $totalClient,
            $commission->total_payment,
            $commission->percentage,
            $commission->total_commission,
            
        ] ;
    }
  
    public function headings(): array
    {
        return ['#','Name','Product','Account Number', 'Account Type','Status','Number Of Client','Total Payment','Persentage','Total Commission'];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
            $cellRange = 'A1:I3';
            $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
        },
    ];
    }
}
