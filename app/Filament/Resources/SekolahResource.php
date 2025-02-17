<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SekolahResource\Pages;
use App\Filament\Resources\SekolahResource\RelationManagers;
use App\Models\Sekolah;
use App\Models\Unit;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SekolahResource extends Resource
{
    protected static ?string $model = Sekolah::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $modelLabel = 'Sekolah';

    protected static ?string $navigationLabel = 'Sekolah';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('telp')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Radio::make('jenis')
                            ->label('Jenis')
                            ->options([
                                'Utama' => 'Utama',
                                'Cabang' => 'Cabang',
                            ]),
                        Forms\Components\Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make("Pengelola")
                            ->collapsible()
                            ->schema([
                                Forms\Components\Select::make('yayasan_id')
                                    ->relationship('yayasan', 'nama')
                                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->nama} | Ketua : {$record->ketua_yayasan}"),
                                Forms\Components\Select::make('user_id')
                                    ->label('Admin Sekolah')
                                    ->multiple()
                                    ->maxItems(2)
                                    ->relationship('admins')
                                    ->getOptionLabelFromRecordUsing(fn(Model $record) => $record->profile ? $record->profile->nama_lengkap : "username: " . $record->name)
                                    ->preload()
                                    ->searchable(),
                            ])
                            ->visible(!auth()->user()->hasRole('Admin Sekolah'))
                            ->columnSpan(1),
                    ]),
            ])
            ->columns([
                'default' => 3,
                'sm' => 3,
                'md' => 3,
                'lg' => 3,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('nama')
                    ->description(fn(Sekolah $record): string => "Alamat : {$record->alamat}")
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis')
                    ->sortable(),
                Tables\Columns\TextColumn::make('units.nama_unit')
                    ->badge()
                    ->separator(','),
                Tables\Columns\TextColumn::make('admins.profile.nama_lengkap')
                    ->label('Admin Sekolah')
                    ->badge()
                    ->listWithLineBreaks()
                    ->getStateUsing(function (Model $record) {
                        $admins = $record->admins;
                        $listAdmin = [];
                        foreach ($admins as $admin) {
                            $listAdmin[] = $admin->profile->nama_lengkap ?? "username: {$admin->name}";
                        }
                        return $listAdmin;
                    })
                    ->default('Admin sekolah belum ditetapkan')
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
            ->groups([
                Tables\Grouping\Group::make('yayasan.nama')
                    ->collapsible(),
                Tables\Grouping\Group::make('jenis')
                    ->collapsible(),
            ])
            ->defaultGroup('yayasan.nama')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Unit')
                    ->form([
                        Forms\Components\Select::make('nama_unit')
                            ->options([
                                'Paud' => 'Paud',
                                'SD' => 'Sekolah Dasar',
                                'SMP' => 'Sekolah Menengah Pertama',
                                'SMA' => 'Sekolah Menengah Atas',
                            ])
                            ->disableOptionWhen(
                                fn(string $value, Unit $unit, Model $sekolah): bool =>
                                in_array(
                                    $value,
                                    $unit->where('sekolah_id', $sekolah->id)->pluck('nama_unit')->toArray()
                                )
                            )
                            ->required()
                            ->columnSpanFull()
                    ])
                    ->action(function (array $data, Model $sekolah): void {
                        $unit = Unit::where([
                            'nama_unit' => $data['nama_unit'],
                            'sekolah_id' => $sekolah->id
                        ])->first();

                        if ($unit) {
                            Notification::make()
                                ->warning()
                                ->title('Registrasi unit gagal')
                                ->body('Nama unit telah terdaftar')
                                ->send();
                        } else {
                            Unit::create([
                                'nama_unit' => $data['nama_unit'],
                                'sekolah_id' => $sekolah->id
                            ]);

                            Notification::make()
                                ->success()
                                ->title('Registrasi unit berhasil')
                                ->body('Unit baru telah ditambahkan')
                                ->send();
                        }
                    })
                    ->icon('heroicon-m-plus-circle')
                    ->color('primary'),
                Tables\Actions\EditAction::make()
                    ->successRedirectUrl(route('filament.admin.resources.sekolahs.index')),
                Tables\Actions\DeleteAction::make()
                    ->action(function ($record): void {
                        $record->admins()->detach();
                        $record->delete();
                        Notification::make()
                            ->success()
                            ->title('Sukses')
                            ->body('Data sekolah berhasil dihapus')
                            ->send();
                    })
                    ->before(function (Tables\Actions\DeleteAction $action, $record) {
                        if (!$record->units->isEmpty()) {
                            Notification::make()
                                ->danger()
                                ->title('Terjadi Kesalahan')
                                ->body('Sekolah ini memiliki unit yang terhubung dengannya')
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\UnitRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSekolahs::route('/'),
            'create' => Pages\CreateSekolah::route('/create'),
            'edit' => Pages\EditSekolah::route('/{record}/edit'),
        ];
    }
}