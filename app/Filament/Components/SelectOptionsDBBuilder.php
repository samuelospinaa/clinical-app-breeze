<?php

namespace App\Filament\Components;

use App\Models\SelectOption;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class SelectOptionsDBBuilder
{
    public function __construct(public string $name, public string $label, public ?bool $isRequired, public ?string $optionType) {
       //
    }

    public function schema(): Select
    {
        return Select::make($this->name)
           ->label($this->label)
           ->required($this->isRequired)
           ->options(function () {
              return SelectOption::where('option_type', $this->optionType ?? $this->name)->pluck('name', 'id');
           })
           ->createOptionForm([
              TextInput::make('name')->required(),
              Hidden::make('option_type')->default($this->optionType ?? $this->name)
           ])
           ->createOptionUsing(function (array $data): int {
              $option = SelectOption::create($data);
              return $option->id;
           })
           ->searchable();
    }

    public static function make(string $name, string $label, bool $isRequired = false, string $optionType = null): SelectOptionsDBBuilder
    {
       return new self($name, $label, $isRequired, $optionType);
    }
}
