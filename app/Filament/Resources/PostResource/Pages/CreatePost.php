<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Пост создан, Чепушила!';
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->icon('heroicon-o-archive-box-arrow-down')
            ->success()
            ->title('Пост создан, Чепушила!')
            ->body('Смотри пост, Чепушила, в разделе постов');
    }
}
