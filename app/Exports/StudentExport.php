<?php

namespace App\Exports;

use App\Student;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class StudentExport implements FromQuery, WithHeadings, WithEvents
{
    use RegistersEventListeners;
    use Exportable;
    protected $status;
    protected $stage;


    public function __construct(int $status, int $stage)
    {
        $this->status = $status;
        $this->stage = $stage;

    }

    public function query()
    {
        $students =  Student::select('code','name','nick_name','dob','gender','phone_no','email','extra_activity','status','source','note','compaign',
                            'father_name','father_phone_no','mother_name','mother_phone_no','guardian','guardian_phone_no',
                            'present_address','permanent_address','created_at')
                        ->if($this->status, 'status', '=' , $this->status)
                        ->where('stage', $this->stage);
        
        return $students;
    }
  
    public function headings(): array
    {
        return ["Code", "Name","Nick_Name", "BoD", "Gender", "Phone", "Email", "Activity", "Status", "Source", "Note", "Compaign",
                "Father_Name", "Father_Phone", "Mother_Name", "Mother_Phone", "Guardian", "Guardian_Phone",
                "Present_Address", "Permanent_Address", "Create_At"];
    }

      /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->getProperties()->setCreator('Patrick');
            },
            // Array callable, refering to a static method.
            AfterSheet::class   => [self::class, 'afterSheet'],
        ];
    }
    

    public static function afterSheet(AfterSheet $event)
    {
        try{
            $styleArray = [
                'font'      => [
                    'color' => ['rgb' => '333'],
                    'bold' => 'true',
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'indent'     => 1,
                ],
                'borders'   => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color'       => ['argb' => '848484'],
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                ]
            ];
            
            $event->sheet->getStyle('A1:X1')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('A1:X1')->applyFromArray($styleArray);
            $event->sheet->getStyle('A1:X1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('d2d6de');
            
       
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            die;
        }
        
    }
}
