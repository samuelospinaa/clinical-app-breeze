<?php

namespace App\Filament\Resources;

use App\Filament\Admin\Resources\Shop\OrderResource\Schema\OrderSchema;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Pack;
use App\Models\Patient;
use App\Models\Service;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class OrderResource extends Resource
{
   protected static ?string $model = Order::class;
   protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
   protected static ?string $label = "Orden";
   protected static ?string $pluralLabel = "Ordenes";
   protected static bool $shouldRegisterNavigation = false;

   private static function addOrUpdateItem(&$array, $newItem): void
   {
      foreach ($array as $key => $item) {
         if ($item["product_id"] === $newItem["product_id"]) {
            $array[$key]["quantity"]++;
            return;
         }
      }

      $array[] = $newItem;
   }

   public static function form(Form $form): Form
   {
      return $form
         ->schema([
            Forms\Components\Group::make()
               ->schema([
                  Forms\Components\Select::make('pack')->label('Cargue un Paquete')
                     ->options(Pack::all()->pluck('name', 'id'))
                     ->reactive()
                     ->afterStateUpdated(function (Forms\Set $set, $state) use ($form) {
                        if (!$state) return;

                        $pack = Pack::findOrFail($state);

                        $items = $form->getLivewire()->data['items'] ?? [];

                        foreach ($pack->services as $service) {
                           self::addOrUpdateItem(
                              $items,
                              ["product_id" => $service->id, "product_name" => $service->name, "quantity" => 1]
                           );
                        }

                        $set('items', $items);
                        $set('pack', null);
                     }),

                  Forms\Components\Select::make('service')->label('Cargue un servicio')
                     ->options(Service::all()->pluck('name', 'id'))
                     ->reactive()
                     ->afterStateUpdated(function (Forms\Set $set, $state) use ($form) {
                        if (!$state) return;

                        $service = Service::findOrFail($state);

                        $items = $form->getLivewire()->data['items'] ?? [];

                        self::addOrUpdateItem(
                           $items,
                           ["product_id" => $service->id, "product_name" => $service->name, "quantity" => 1]
                        );

                        $set('items', $items);
                        $set('service', null);
                     }),

                  Forms\Components\Repeater::make('items')
                     ->addable(false)
                     ->defaultItems(0)
                     ->label('Items de la orden')
                     ->schema([
                        Forms\Components\Hidden::make('product_id'),
                        Forms\Components\TextInput::make('product_name')->label('Producto')->readOnly(),
                        Forms\Components\TextInput::make('quantity')->label('Cantidad')->numeric()->minValue(0),
                     ])
                     ->columns(2)
                     ->grid(2)
                     ->reorderable(false)
                     ->columnSpanFull()
                     ->itemLabel(fn (array $state): ?string => $state['product_id'] ? "Product_ID {$state['product_id']}" : null)
               ])
               ->columns(2)
               ->columnSpan(3),

            Forms\Components\Group::make()
               ->schema([
                  Forms\Components\Select::make('patient_id')
                     ->label('Seleccione un paciente')
                     ->options(Patient::all()->pluck('name', 'id'))
                     ->reactive()
                     ->columnSpanFull(),

                  Forms\Components\Select::make('payment_method')
                     ->label('Metodo de pago')
                     ->options([
                        "transferencia" => "Transferencia",
                        "crédito" => "Crédito",
                     ]),

                  Forms\Components\TextInput::make('total')
                     ->label('Valor de la órden')->numeric()
               ])
               ->columnSpan(1),
         ])->columns(4);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->columns([
            //
         ])
         ->filters([
            //
         ])
         ->actions([
            Tables\Actions\EditAction::make(),
         ])
         ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
               Tables\Actions\DeleteBulkAction::make(),
            ]),
         ]);
   }

   public static function getRelations(): array
   {
      return [
         //
      ];
   }

   public static function getPages(): array
   {
      return [
         'index' => Pages\ListOrders::route('/'),
         'create' => Pages\CreateOrder::route('/create'),
         'edit' => Pages\EditOrder::route('/{record}/edit'),
      ];
   }
}
