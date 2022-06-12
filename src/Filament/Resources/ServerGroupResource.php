<?php

namespace SquadMS\AdminConfig\Filament\Resources;

use SquadMS\AdminConfig\Filament\Resources\ServerGroupResource\Pages;
use SquadMS\AdminConfig\Models\ServerGroup;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ServerGroupResource extends Resource
{
    protected static ?string $model = ServerGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\ColorPicker::make('color')->required(),

                Forms\Components\Toggle::make('main')->required(),
                Forms\Components\TextInput::make('importance')->integer()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\BooleanColumn::make('main')->sortable(),
                Tables\Columns\TextColumn::make('importance')->sortable()
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
            'index' => Pages\ListServerGroup::route('/'),
            'create' => Pages\CreateServerGroup::route('/create'),
            'edit' => Pages\EditServerGroup::route('/{record}/edit'),
        ];
    }
}
