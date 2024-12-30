<?php

namespace App\Filament\Resources\SekolahResource\RelationManagers;

use App\Models\Unit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnitRelationManager extends RelationManager
{
    protected static string $relationship = 'units';

    protected static ?string $modelLabel = 'Unit';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('nama_unit')
                    ->options([
                        'Paud' => 'Paud',
                        'SD' => 'Sekolah Dasar',
                        'SMP' => 'Sekolah Menengah Pertama',
                        'SMA' => 'Sekolah Menengah Atas',
                    ])
                    ->disableOptionWhen(
                        fn(string $value, Unit $unit): bool =>
                        in_array(
                            $value,
                            $unit->where('sekolah_id', parent::getOwnerRecord()->id)->pluck('nama_unit')->toArray()
                        )
                    )
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_unit')
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('nama_unit')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Register Unit'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Tables\Actions\DeleteAction $action, $record) {
                        if ($record->kelas) {
                            Notification::make()
                                ->danger()
                                ->title('Terjadi Kesalahan')
                                ->body('Unit ini memiliki kelas yang terhubung dengannya')
                                ->send();

                            $action->cancel();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
