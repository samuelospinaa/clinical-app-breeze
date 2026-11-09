<?php

namespace App\Filament\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;
use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;

class InformedConsent extends Page implements HasForms, HasInfolists
{
   use InteractsWithForms;

   protected static ?string $navigationIcon = 'heroicon-o-document-text';
   protected static string $view = 'filament.pages.informed-consent';
   protected static ?string $navigationGroup = 'Reportes';
   protected static ?string $navigationLabel = 'Consentimiento informado';
   protected static ?string $title = 'Consentimiento informado';
   protected static bool $shouldRegisterNavigation = false;

   public ?array $data = [];

   protected $rules = [
      'signature' => 'required',
   ];

   public static function canAccess(): bool
   {
      return auth()->user()->checkPermissionTo('page_RipsReports');
   }

   public function form(Form $form): Form
   {
      return $form
         ->schema([

         ])
         ->columns(1)
         ->statePath('data');
   }

   public static function infolist(Infolist $infolist): Infolist
   {
      return $infolist
         ->state([])
         ->schema([
            PdfViewerEntry::make('file')
               ->fileUrl(Storage::url('informedConsent/document.pdf'))
               ->label('')
               ->minHeight('100svh')
         ]);
   }

   protected function getFormActions(): array
   {
      return [
         Action::make('sign')
            ->label('Firmar')
            ->submit('sign'),
      ];
   }


   public function sign()
   {
      try {
         $data = $this->form->getState();

         $signature = $data['signature'];
dd($data, $signature);

         Notification::make()
            ->success()
            ->persistent()
            ->title('Excelente!!!')
            ->body('Rips descargados!!')
            ->send();

         $this->form->fill();
         //return Excel::download(new RipsExport($month, $year), "rips-{$month}-{$year}.xlsx");
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
