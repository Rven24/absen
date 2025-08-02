<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Filament\Resources\UserResource\RelationManagers\AttendancesRelationManager;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('email')->email()->required()->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
                Forms\Components\Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'karyawan' => 'Karyawan',
                    ])
                    ->required(),
                Forms\Components\Select::make('shift')
                    ->label('Shift')
                    ->options([
                        'pagi' => 'Karyawan Pagi',
                        'malam' => 'Karyawan Malam',
                    ])
                    ->default('pagi')
                    ->required(),
            ]);
    }

    public static function canViewAny(): bool
    {
        // ! Hanya izinkan user dengan role 'admin' untuk melihat daftar user
        return auth()->user()->role === 'admin';
    }

    public static function canCreate(): bool
    {
        // ! Hanya izinkan admin untuk membuat user baru
        return auth()->user()->role === 'admin';
    }

    public static function canEdit(Model $record): bool
    {
        // ! Hanya izinkan admin untuk mengedit user
        return auth()->user()->role === 'admin';
    }

    public static function canDelete(Model $record): bool
    {
        // ! Hanya izinkan admin untuk menghapus user
        return auth()->user()->role === 'admin';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('role')->badge()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            // ! Daftarkan Relation Manager Anda di sini
            AttendancesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

}

