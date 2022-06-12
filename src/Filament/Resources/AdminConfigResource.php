<?php

namespace SquadMS\AdminConfig\Filament\Resources;

use SquadMS\AdminConfig\Filament\Resources\AdminConfigResource\Pages;
use SquadMS\AdminConfig\Filament\Resources\AdminConfigResource\RelationManagers;
use SquadMS\AdminConfig\Models\AdminConfig;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class AdminConfigResource extends Resource
{
    protected static ?string $model = AdminConfig::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->rules('required|string|min:1|max:255')
                    ->unique(AdminConfig::class)
                    ->required(),
                Forms\Components\BelongsToSelect::make('reserved_group_id')
                    ->relationship('reservedGroup', 'name')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\BooleanColumn::make('name')->getStateUsing(fn (AdminConfig $config) => $config->reserved_group_id)->sortable(),
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
            'index' => Pages\ListAdminConfigs::route('/'),
            'create' => Pages\CreateAdminConfig::route('/create'),
            'edit' => Pages\EditAdminConfig::route('/{record}/edit'),
        ];
    }
}
