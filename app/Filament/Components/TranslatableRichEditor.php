<?php

namespace App\Filament\Components;

use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;

class TranslatableRichEditor
{
    public static function make(string $field, array $locales, string $height = "300px"): array
    {
        $defaultLocale = array_key_first($locales);

        return [
            Hidden::make($field)
                ->default([]),

            Group::make()
                ->schema([
                    Select::make("{$field}_active_locale")
                        ->label('Editing language')
                        ->options($locales)
                        ->default($defaultLocale)
                        ->live()
                        ->native(false)
                        ->searchable()
                        ->afterStateUpdated(function ($state, $set, $get) use ($field) {
                            $values = $get($field) ?? [];

                            if (! is_array($values)) {
                                $values = [];
                            }

                            $set("{$field}_input", $values[$state] ?? null);
                        }),

                    RichEditor::make("{$field}_input")
                        ->label(function ($get) use ($field, $locales, $defaultLocale) {
                            $locale = $get("{$field}_active_locale") ?? $defaultLocale;

                            return ucfirst($field) . ' (' . ($locales[$locale] ?? $locale) . ')';
                        })
                        ->toolbarButtons([
                            'attachFiles',
                            'customBlocks',
                            'blockquote',
                            'bold',
                            'bulletList',
                            'codeBlock',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ])
                        ->customBlocks([
                            \App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\InfoUserBlock::class,
                        ])
                        ->columnSpanFull()
                        ->live()
                        ->extraAttributes([
                            'style' => "min-height: {$height};",
                        ])
                        ->afterStateHydrated(function ($set, $get) use ($field, $defaultLocale) {
                            $locale = $get("{$field}_active_locale") ?? $defaultLocale;
                            $values = $get($field) ?? [];

                            if (! is_array($values)) {
                                $values = [];
                            }

                            $set("{$field}_input", $values[$locale] ?? '');
                        })
                        ->afterStateUpdated(function ($state, $set, $get) use ($field, $defaultLocale) {
                            $locale = $get("{$field}_active_locale") ?? $defaultLocale;
                            $values = $get($field) ?? [];

                            if (! is_array($values)) {
                                $values = [];
                            }

                            $values[$locale] = $state;

                            $set($field, $values);
                        }),
                ])
                ->columnSpanFull(),
        ];
    }
}
