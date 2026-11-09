<x-filament-panels::page>
   {{ $this->infolist }}

   <x-filament-panels::form wire:submit="sign">
      {{ $this->form }}

      <x-filament-panels::form.actions
         :actions="$this->getFormActions()"
      />
   </x-filament-panels::form>
</x-filament-panels::page>
