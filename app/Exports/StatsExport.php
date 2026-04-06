<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StatsExport implements FromCollection, WithHeadings
{
    protected $data;

    // استلام البيانات من الكنترولر
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // تحويل المصفوفة إلى Collection ليفهمها الإكسل
        return collect([$this->data]);
    }

    // أسماء الأعمدة في ملف الإكسل
    public function headings(): array
    {
        return [
            'إجمالي المستخدمين',
            'إجمالي التبرعات',
            'إجمالي الكيانات',
            'الكيانات المعلقة',
            'تاريخ التقرير'
        ];
    }
}
