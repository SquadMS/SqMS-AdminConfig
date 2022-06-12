<?php

namespace SquadMS\AdminConfig\Filament\Resources;

use SquadMS\AdminConfig\Filament\Resources\ServerPermissionResource\Pages;
use SquadMS\AdminConfig\Models\ServerPermission;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ServerPermissionResource extends Resource
{
    protected static ?string $model = ServerPermission::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->rules('required|string|min:1|max:255')
                    ->required(),
                Forms\Components\TextInput::make('config_key')
                    ->rules('required|string|min:1|max:255')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TextColumn::make('config_key')->sortable()
            ])
            ->filters([
                //
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
            'index' => Pages\ListServerPermission::route('/'),
            'create' => Pages\CreateServerPermission::route('/create'),
            'edit' => Pages\EditServerPermission::route('/{record}/edit'),
        ];
    }
}
