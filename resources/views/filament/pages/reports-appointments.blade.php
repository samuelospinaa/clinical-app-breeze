<x-filament-panels::page>
   @if(!request()->patient)
      {{ $this->form }}
      <x-filament-panels::form.actions
         :actions="$this->getFormActions()"
      />
   @endif

   <div class="space-y-6">
      <!-- Renderiza las tarjetas -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
         @foreach ($this->getCards() as $card)
            <div>
               {{ $card }}
            </div>
         @endforeach
      </div>
   </div>

   {{ $this->table }}
</x-filament-panels::page>
