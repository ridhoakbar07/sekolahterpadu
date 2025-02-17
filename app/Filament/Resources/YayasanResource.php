<?php

namespace App\Filament\Resources;

use App\Filament\Resources\YayasanResource\Pages;
use App\Models\Yayasan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class YayasanResource extends Resource
{
    protected static ?string $model = Yayasan::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $modelLabel = 'Yayasan';

    protected static ?string $navigationLabel = 'Yayasan';

    protected static ?int $navigationSort = 0;

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_pendirian'),
                Forms\Components\Textarea::make('alamat')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('telp')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\Textarea::make('visi_misi')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('no_status_hukum')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ketua_yayasan')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_pendirian')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('telp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_status_hukum')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ketua_yayasan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->successRedirectUrl(route('filament.admin.resources.yayasans.index')),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListYayasans::route('/'),
            'create' => Pages\CreateYayasan::route('/create'),
            'edit' => Pages\EditYayasan::route('/{record}/edit'),
        ];
    }
}
