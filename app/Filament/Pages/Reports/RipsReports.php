<?php

namespace App\Filament\Pages\Reports;

use App\Exports\RipsExport;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Maatwebsite\Excel\Facades\Excel;

class RipsReports extends Page implements HasForms
{
   use InteractsWithForms;

   protected static ?string $navigationIcon = 'heroicon-o-document-text';
   protected static string $view = 'filament.pages.rips-reports';
   protected static ?string $navigationGroup = 'Reportes';
   protected static ?string $navigationLabel = 'Descargar Rips';
   protected static ?string $title = 'Descargar Rips';

   public ?array $data = [];

   protected $rules = [
      'month' => 'required',
      'year' => 'required',
   ];

   public static function canAccess(): bool
   {
       return auth()->user()->checkPermissionTo('page_RipsReports');
   }

    public function form(Form $form): Form
   {
      return $form
         ->schema([
            Forms\Components\Select::make('month')
               ->label('Mes')
               ->required()
               ->options([
                  "01" => "Enero",
                  "02" => "Febrero",
                  "03" => "Marzo",
                  "04" => "Abril",
                  "05" => "Mayo",
                  "06" => "Junio",
                  "07" => "Julio",
                  "08" => "Agosto",
                  "09" => "Septiembre",
                  "10" => "Octubre",
                  "11" => "Noviembre",
                  "12" => "Diciembre",
               ]),
            Forms\Components\Select::make('year')
               ->label('Año')
               ->required()
               ->options([
                  "2023" => "2023",
                  "2024" => "2024",
               ]),
         ])
         ->columns(2)
         ->statePath('data');
   }

   protected function getFormActions(): array
   {
      return [
         Action::make('download')
            ->label('Descargar')
            ->submit('download'),
      ];
   }


   public function download()
   {
      try {
         $data = $this->form->getState();

         $month = $data['month'];
         $year = $data['year'];


         Notification::make()
            ->success()
            ->persistent()
            ->title('Excelente!!!')
            ->body('Rips descargados!!')
            ->send();

         $this->form->fill();
         return Excel::download(new RipsExport($month, $year), "rips-{$month}-{$year}.xlsx");
      } catch (Halt $exception) {
         Notification::make()
            ->warning()
            ->persistent()
            ->title('Uuupss!!')
            ->body($exception->getMessage())
            ->send();

         return;
      } catch (\Throwable $error) {
         Notification::make()
            ->warning()
            ->persistent()
            ->title('Uuupss!!')
            ->body($error->getMessage())
            ->send();

         return;
      }
   }
}
