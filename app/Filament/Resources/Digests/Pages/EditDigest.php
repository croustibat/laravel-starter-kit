<?php

namespace App\Filament\Resources\Digests\Pages;

use App\Filament\Resources\Digests\DigestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDigest extends EditRecord
{
    protected static string $resource = DigestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
