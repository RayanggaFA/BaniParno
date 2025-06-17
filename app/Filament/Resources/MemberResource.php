<?php
// app/Filament/Resources/MemberResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Filament\Resources\MemberResource\RelationManagers;
use App\Models\Member;
use App\Models\Family;
use App\Models\Generation; // Tambahkan ini
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Anggota Keluarga';
    protected static ?string $pluralLabel = 'Anggota Keluarga';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pribadi')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Select::make('family_id')
                            ->label('Keluarga')
                            ->relationship('family', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        
                        // TAMBAHKAN FIELD GENERATION INI
                        Forms\Components\Select::make('generation_id')
                            ->label('Generasi')
                            ->relationship('generation', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        
                        Forms\Components\Select::make('parent_id')
                            ->label('Orang Tua')
                            ->relationship('parent', 'name')
                            ->searchable()
                            ->preload(),
                        
                        Forms\Components\Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'male' => 'Laki-laki',
                                'female' => 'Perempuan',
                            ])
                            ->required(),
                        
                        Forms\Components\FileUpload::make('photo')
                            ->label('Foto')
                            ->image()
                            ->directory('member-photos')
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('300'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Tempat & Tanggal Lahir')
                    ->schema([
                        Forms\Components\TextInput::make('birth_place')
                            ->label('Tempat Lahir')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->required()
                            ->displayFormat('d F Y'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Pekerjaan & Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('job')
                            ->label('Pekerjaan')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                    ])
                    ->columns(3),
                
                Forms\Components\Section::make('Alamat')
                    ->schema([
                        Forms\Components\Textarea::make('address_ktp')
                            ->label('Alamat KTP')
                            ->required()
                            ->rows(2),
                        
                        Forms\Components\TextInput::make('domicile_city')
                            ->label('Kota Domisili')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('domicile_province')
                            ->label('Provinsi Domisili')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('current_address')
                            ->label('Alamat Domisili Saat Ini')
                            ->required()
                            ->rows(2),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Status & Catatan')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Aktif',
                                'inactive' => 'Tidak Aktif',
                                'deceased' => 'Meninggal Dunia',
                            ])
                            ->default('active')
                            ->required(),
                        
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn() => asset('images/default-avatar.png')),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold),
                
                Tables\Columns\TextColumn::make('family.name')
                    ->label('Keluarga')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                
                // UPDATE KOLOM GENERATION
                Tables\Columns\TextColumn::make('generation.name')
                    ->label('Generasi')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('age')
                    ->label('Umur')
                    ->suffix(' tahun')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('job')
                    ->label('Pekerjaan')
                    ->searchable()
                    ->limit(30),
                
                Tables\Columns\TextColumn::make('domicile_city')
                    ->label('Domisili')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'inactive',
                        'danger' => 'deceased',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Aktif',
                        'inactive' => 'Tidak Aktif',
                        'deceased' => 'Meninggal',
                    }),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('family')
                    ->label('Keluarga')
                    ->relationship('family', 'name'),
                
                // TAMBAHKAN FILTER GENERATION
                Tables\Filters\SelectFilter::make('generation')
                    ->label('Generasi')
                    ->relationship('generation', 'name'),
                
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Tidak Aktif',
                        'deceased' => 'Meninggal Dunia',
                    ]),
                
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'male' => 'Laki-laki',
                        'female' => 'Perempuan',
                    ]),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SocialLinksRelationManager::class,
            RelationManagers\HistoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'view' => Pages\ViewMember::route('/{record}'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}