<?php
// app/Filament/Resources/MemberResource/RelationManagers/HistoriesRelationManager.php

namespace App\Filament\Resources\MemberResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class HistoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'histories';
    protected static ?string $title = 'Riwayat Perubahan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('field_changed')
                    ->label('Field yang Diubah')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Textarea::make('old_value')
                    ->label('Nilai Lama')
                    ->rows(2),
                
                Forms\Components\Textarea::make('new_value')
                    ->label('Nilai Baru')
                    ->rows(2),
                
                Forms\Components\TextInput::make('changed_by')
                    ->label('Diubah Oleh')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Textarea::make('reason')
                    ->label('Alasan Perubahan')
                    ->rows(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('field_changed')
            ->columns([
                Tables\Columns\TextColumn::make('field_changed')
                    ->label('Field')
                    ->badge()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('old_value')
                    ->label('Nilai Lama')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->old_value),
                
                Tables\Columns\TextColumn::make('new_value')
                    ->label('Nilai Baru')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->new_value),
                
                Tables\Columns\TextColumn::make('changed_by')
                    ->label('Diubah Oleh')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}