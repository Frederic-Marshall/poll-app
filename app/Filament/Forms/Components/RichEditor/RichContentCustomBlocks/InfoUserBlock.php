<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;

class InfoUserBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'info_user';
    }

    public static function getLabel(): string
    {
        return 'Info User Block';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalHeading('Configure user block')
            ->modalDescription('Select icon and user')
            ->schema([
                Select::make('icon')
                    ->label('Icon')
                    ->options([
                        Heroicon::User->value => 'User Icon',
                    ])
                    ->required(),

                Select::make('user_id')
                    ->label('User')
                    ->searchable()
                    ->getSearchResultsUsing(function (string $search) {
                        return User::query()
                            ->where('name', 'like', "%{$search}%")
                            ->limit(10)
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->getOptionLabelUsing(fn ($value): ?string =>
                    User::find($value)?->name
                    )
                    ->required(),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.info-user.preview', [
            //
        ])->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.info-user.index', [
            //
        ])->render();
    }
}
