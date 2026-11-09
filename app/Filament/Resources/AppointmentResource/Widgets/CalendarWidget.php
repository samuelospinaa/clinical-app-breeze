<?php

namespace App\Filament\Resources\AppointmentResource\Widgets;

use App\Filament\Resources\AppointmentResource;
use App\Helpers\HolidayCalculator;
use App\Models\Appointment;
use App\Models\AppointmentType;
use App\Models\Patient;
use App\Models\Professional;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use HusamTariq\FilamentTimePicker\Forms\Components\TimePickerField;
use Saade\FilamentFullCalendar\Actions;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use \Illuminate\Database\Eloquent\Model;
use Filament\Support\Colors\Color;
use stdClass;

class CalendarWidget extends FullCalendarWidget
{
    public static string $resource = AppointmentResource::class;

    public string|null|Model $model = Appointment::class;
    protected ?string $modelLabel = "Cita";

    public function fetchEvents(array $fetchInfo): array
    {
        $holidays = (new HolidayCalculator())->holidays;

        $holidays = collect($holidays)->map(function ($appointment) {
            $data = new StdClass();
            $data->id = rand(0, 99999999);
            $data->title = "FESTIVO";
            $data->start = "{$appointment}T00:00:00";
            $data->end = "{$appointment}T23:59:59";
            $data->allDay = true;
            $data->backgroundColor = '#0891b2';

            return $data;
        })->all();

        $appointments = Appointment::query()
            ->with(['patient', 'appointmentType'])
            ->get()
            ->map(function (Appointment $appointment) {
                $start_date = new \DateTime("{$appointment->date} {$appointment->start_time}");
                $end_date = new \DateTime("{$appointment->date} {$appointment->end_time}");

                $data = new StdClass();
                $data->id = $appointment->id;
                $data->title = $appointment->patient->name;
                $data->start = $start_date->format('Y-m-d\TH:i:s');
                $data->end = $end_date->format('Y-m-d\TH:i:s');
                $data->backgroundColor = $appointment->appointmentType ? $appointment->appointmentType->color : '#000';

                return $data;
            })
            ->all();

        //dd(array_merge($appointments, $holidays));
        return array_merge($appointments, $holidays);
    }

    public function getFormSchema(): array
    {
        return [
            Grid::make()
                ->schema([
                    TextInput::make('price')
                        ->numeric()
                        ->minValue(0)
                        ->default(0)
                        ->required()
                        ->label('Precio'),

                    Select::make('appointment_type_id')
                        ->label('Tipo de cita')
                        ->options(AppointmentType::all()->pluck('id', 'name'))
                        ->columnSpan(2)
                        ->relationship('appointmentType', 'name')
                ])
                ->columns(3),

            Grid::make()
                ->schema([
                    DatePicker::make('date')
                        ->label('Fecha')
                        ->required(),
                    TimePickerField::make('start_time')
                        ->label('Hora de inicio')
                        ->okLabel("Confirm")
                        ->cancelLabel("Cancel")
                        ->required(),
                    TimePickerField::make('end_time')
                        ->label('Hora de finalización')
                        ->okLabel("Confirm")
                        ->cancelLabel("Cancel")
                        ->required(),
                ])
                ->columns(3),

            Grid::make()
                ->schema([
                    Select::make('patient_id')
                        ->label('Paciente')
                        ->required()
                        ->options(function () {
                            return Patient::all()->pluck('name', 'id');
                        })
                        ->searchable(),

                    Select::make('professional_id')
                        ->label('Profesional')
                        ->required()
                        ->options(function () {
                            return Professional::all()->pluck('name', 'id');
                        })
                        ->searchable(),
                ]),

            RichEditor::make('notes')->label('Nota')
        ];
    }

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Crear cita')
                ->color(Color::Gray)
                ->mountUsing(function (Form $form, array $arguments) {
                    $form->fill([
                        'date' => $arguments['date'] ?? '',
                    ]);
                })
        ];
    }

    protected function modalActions(): array
    {
        return [
            ...parent::modalActions(),
            Action::make('Visitar el paciente')
                ->color(Color::Gray)
                ->url(
                    fn(Appointment $appointment): string => route(
                        'filament.admin.resources.patients.edit',
                        ['record' => $appointment->patient]
                    ),
                    true
                ),
            Action::make('attended')
                ->label(fn(Appointment $record) => $record->attended ? 'Marcar como no asistido' : 'Marcar como asistido')
                ->color(fn(Appointment $record) => $record->attended ? Color::Red : Color::Green)
                ->action(fn(Appointment $record) => $record->update(["attended" => !$record->attended])),
        ];
    }

    public function onDateSelect(string $start, ?string $end, bool $allDay, ?array $view, ?array $resource): void
    {
        $holidays = (new HolidayCalculator())->nonBusinessDays;

        if (in_array($start, $holidays)) {
            return;
        }

        [$start, $end] = $this->calculateTimezoneOffset($start, $end, $allDay);

        $formattedDate = $start->format('Y-m-d');

        $this->mountAction('create', [
            "date" => $formattedDate
        ]);
    }

    public function onEventClick(array $event): void
    {
        if ($event['title'] === 'FESTIVO') {
            return;
        }

        parent::onEventClick($event);
    }

    protected function openActionModal(): void
    {
        $isRecord = isset($this->record);

        if (!$isRecord && !auth()->user()->can('create_appointment')) {
            abort(401, 'Not Authorize');
        }

        if ($isRecord && !auth()->user()->can('update_appointment')) {
            abort(401, 'Not Authorize');
        }

        $this->dispatch('open-modal', id: "{$this->getId()}-action");
    }
}
