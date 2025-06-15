<?php
// app/Filament/Resources/FamilyResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\FamilyResource\Pages;
use App\Models\Family;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FamilyResource extends Resource
{
    protected static ?string $model = Family::class;
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Keluarga';
    protected static ?string $pluralLabel = 'Keluarga';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Keluarga')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('branch')
                    ->label('Cabang Keluarga')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: Parno 1, Parno 2'),
                
                Forms\Components\Select::make('generation')
                    ->label('Generasi')
                    ->options([
                        1 => 'Generasi Pertama',
                        2 => 'Generasi Kedua',
                        3 => 'Generasi Ketiga',
                        4 => 'Generasi Keempat',
                        5 => 'Generasi Kelima',
                    ])
                    ->required(),
                
                Forms\Components\ColorPicker::make('color')
                    ->label('Warna Identitas')
                    ->default('#3B82F6'),
                
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Keluarga')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('branch')
                    ->label('Cabang')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('generation')
                    ->label('Generasi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'success',
                        '2' => 'info',
                        '3' => 'warning',
                        '4' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('members_count')
                    ->label('Jumlah Anggota')
                    ->counts('members')
                    ->sortable(),
                
                Tables\Columns\ColorColumn::make('color')
                    ->label('Warna'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('generation')
                    ->label('Generasi')
                    ->options([
                        1 => 'Generasi Pertama',
                        2 => 'Generasi Kedua',
                        3 => 'Generasi Ketiga',
                        4 => 'Generasi Keempat',
                        5 => 'Generasi Kelima',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFamilies::route('/'),
            'create' => Pages\CreateFamily::route('/create'),
            'edit' => Pages\EditFamily::route('/{record}/edit'),
        ];
    }
}