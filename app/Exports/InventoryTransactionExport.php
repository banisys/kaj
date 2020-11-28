<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryTransactionExport implements WithHeadings, FromCollection// WithEvents, FromQuery,
{
    protected $__collection;
    
    public function __construct($rows)
    {
        $output = [];
        
        foreach ($rows as $row) 
        {
            $effect_price_name = $row->inventory['effect_price_name'] ?? null;
            $effect_spec_name = $row->inventory['effect_spec_name'] ?? null;
            $specs = (isset($effect_price_name) && isset($effect_spec_name)) ? $effect_price_name.":".$effect_spec_name."\r\n" : '';
            
            $color_name = $row->inventory['color_name'];
            $specs .= (isset($color_name)) ? "رنگ".":".$color_name : '';
            
            $final_price =(isset($row->inventory)) ? $row->inventory['product_price'] * (1 - $row->inventory['product_discount'])/100 : '';
            
            $info ="";
             
            if (isset($row['info']))
            {
                $info = 'نوع : ';
                switch ($row->info['type'])
                {
                    case 'add':
                        $info .= 'افزایش موجودی';
                        break;
                    case 'remove':
                        $info .= 'کاهش موجودی';
                        break;
                    case 'change':
                        $info .= 'تغییر موجودی';
                        break;
                    case 'sell':
                        $info .= 'فروش';
                        break;
                    default:
                        $info .= 'نامشخص';
                        break;
                                    
                }
                
                if (isset($row->info['factor_num']))
                    $info .="\r\n"."شماره فاکتور: " . $row->info['factor_num'];
                    
                if (isset($row->info['user_phone']))
                    $info .="\r\n"."تلفن مشتری: " . $row->info['user_phone'];
                    
            }
            
            $output[] = [ 
                'product_code' => $row->product_code,
                'product_name' => $row->inventory['product_name'] ?? '',
                'specs' => $specs,
                'user_id' => $row->user_id,
                'created_at' => $row->created_at,
                'balance' => $row->balance,
                'old_balance' => $row->old_balance,
                'product_price' => $row->inventory['product_price'],
                'final_price' => $final_price,
                'info' => $info,
                ];
        }
        
        $this->__collection = collect($output);
    }
    
    public function collection()
    {
        return $this->__collection;
    }
  
    public function headings(): array
    {
        return ['کد محصول','نام محصول','ویژگی ها','شناسه کاربر','تاریخ','موجودی جدید','موجودی قبلی','قیمت اصلی','قیمت نهایی','توضیحات',       ];
    }

    
    // /**
    //  * @return array
    //  */
    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class    => function(AfterSheet $event) {
    //             $event->sheet->getDelegate()->setRightToLeft(true);
    //         },
    //         BeforeExport::class  => function(BeforeExport $event) {
    //             $event->writer->setCreator('termetan');
    //         },
    //         AfterSheet::class    => function(AfterSheet $event) {
    //             $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

    //             $event->sheet->styleCells(
    //                 'B2:G8',
    //                 [
    //                     'borders' => [
    //                         'outline' => [
    //                             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
    //                             'color' => ['argb' => 'FFFF0000'],
    //                         ],
    //                     ]
    //                 ]
    //             );
    //         },
    //     ];
    // }
}