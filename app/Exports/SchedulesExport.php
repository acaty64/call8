<?php

namespace App\Exports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SchedulesExport implements FromCollection, WithHeadings, WithMapping
{

    protected $scheduleIDs;

    public function __construct($scheduleIDs)
    {
        $this->scheduleIDs = $scheduleIDs;
    }

    public function headings(): array
    {
        return [
        	'Oficina',
        	'Operador',
        	'Dia',
        	'Hora inicio',
        	'Hora fin',
        	'Fecha inicio',
        	'Fecha fin',
        ];
    }

    public function map($schedule): array
    {
    	return [
    		$schedule->office->name,
    		$schedule->host->name,
    		$schedule->day,
    		$schedule->hour_start,
    		$schedule->hour_end,
    		$schedule->date_start,
    		$schedule->date_end,
    	];
    }

    public function collection()
    {
    	return Schedule::with(['office', 'host'])->find($this->scheduleIDs);
    }

}
