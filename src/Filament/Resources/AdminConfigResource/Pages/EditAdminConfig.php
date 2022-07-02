<?php

namespace SquadMS\AdminConfig\Filament\Resources\AdminConfigResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use SquadMS\AdminConfig\Filament\Resources\AdminConfigResource;

class EditAdminConfig extends EditRecord
{
    protected static string $resource = AdminConfigResource::class;

    protected function getActions(): array
    {
        return array_merge(parent::getActions(), [
            Action::make('settings')
                ->label('View')
                ->url(route('remoteAdmin', [
                    'adminconfig' => $this->record,
                ])),
        ]);
    }
}
