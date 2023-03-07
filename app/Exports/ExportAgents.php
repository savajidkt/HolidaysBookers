<?php

namespace App\Exports;

use App\Models\Agent;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class ExportAgents implements FromView, WithEvents
{
    protected $agents;

    function __construct($agents)
    {
        $this->agents = $agents;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {

        return view('admin.agent.agent-export', [
            'agents' => $this->agents
        ]);
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
                foreach ($columns as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            },

        ];
    }
}
