<?php

namespace App\Filament\Resources\Polls\Schemas;

use App\Enums\PollStatus;
use App\Filament\Components\TranslatableRichEditor;
use App\Filament\Components\TranslatableTextInput;
use App\Filament\Components\TranslatableTextarea;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class PollForm
{
    /**
     * Central place to manage locales
     */
    private static function locales(): array
    {
        return [
            'en' => 'English',
            'ru' => 'Russian',
            'uk' => 'Ukrainian',
            'de' => 'German',
            'fr' => 'French',
            'es' => 'Spanish',
            'it' => 'Italian',
            'pt' => 'Portuguese',
            'pt_BR' => 'Portuguese (Brazil)',
            'pl' => 'Polish',
            'cs' => 'Czech',
            'sk' => 'Slovak',
            'hu' => 'Hungarian',
            'ro' => 'Romanian',
            'bg' => 'Bulgarian',
            'sr' => 'Serbian',
            'hr' => 'Croatian',
            'sl' => 'Slovenian',
            'nl' => 'Dutch',
            'sv' => 'Swedish',
            'no' => 'Norwegian',
            'da' => 'Danish',
            'fi' => 'Finnish',
            'et' => 'Estonian',
            'lv' => 'Latvian',
            'lt' => 'Lithuanian',
            'el' => 'Greek',
            'tr' => 'Turkish',
            'ar' => 'Arabic',
            'he' => 'Hebrew',
            'fa' => 'Persian',
            'hi' => 'Hindi',
            'bn' => 'Bengali',
            'ur' => 'Urdu',
            'id' => 'Indonesian',
            'ms' => 'Malay',
            'vi' => 'Vietnamese',
            'th' => 'Thai',
            'zh' => 'Chinese (Simplified)',
            'zh_TW' => 'Chinese (Traditional)',
            'ja' => 'Japanese',
            'ko' => 'Korean',
            'ka' => 'Georgian',
            'hy' => 'Armenian',
            'az' => 'Azerbaijani',
            'kk' => 'Kazakh',
        ];
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

//            Tabs::make('Title')
//                ->columnSpanFull()
//                ->tabs(
//                    array_map(
//                        fn (string $label, string $locale) => Tabs\Tab::make($label)
//                            ->schema([
//                                TextInput::make("title.$locale")
//                                    ->label("Title ($label)")
////                                    ->required()
//                                    ->maxLength(255),
//                            ]),
//                        self::locales(),
//                        array_keys(self::locales())
//                    )
//                ),

//            Tabs::make('Title')
//                ->columnSpanFull()
//                ->tabs([
//                    Tabs\Tab::make('Main')
//                        ->schema([
//                            TextInput::make('title.en')
//                                ->label('English title')
//                                ->required(),
//
//                            TextInput::make('title.ru')
//                                ->label('Russian title')
//                                ->required(),
//
//                            TextInput::make('title.uk')
//                                ->label('Ukrainian title')
//                                ->required(),
//                        ]),
//
//                    Tabs\Tab::make('More languages')
//                        ->schema(
//                            collect(self::locales())
//                                ->except(['en', 'ru', 'uk'])
//                                ->map(fn ($label, $locale) =>
//                                TextInput::make("title.$locale")
//                                    ->label("$label")
//                                )
//                                ->values()
//                                ->toArray()
//                        ),
//                ]),

//                Section::make('Translations')
//                    ->collapsible()
//                    ->schema([
//                        TextInput::make('title.en')->label('English')->required(),
//                        TextInput::make('title.ru')->label('Russian')->required(),
//                        TextInput::make('title.uk')->label('Ukrainian'),
//
//                        Section::make('More languages')
//                            ->collapsible()
//                            ->schema(
//                                collect(self::locales())
//                                    ->except(['en', 'ru', 'uk'])
//                                    ->map(fn ($label, $locale) =>
//                                    TextInput::make("title.$locale")->label($label)
//                                    )
//                                    ->values()
//                                    ->toArray()
//                            ),
//                    ]),

//            Hidden::make('title')
//                ->default([]),
//
//            Select::make('active_locale')
//                ->label('Editing language')
//                ->options(self::locales())
//                ->default('en')
//                ->live()
//                ->afterStateUpdated(function ($state, $set, $get) {
//                    $titles = $get('title') ?? [];
//
//                    if (! is_array($titles)) {
//                        $titles = [];
//                    }
//
//                    $set('title_input', $titles[$state] ?? '');
//                }),
//
//            TextInput::make('title_input')
//                ->label(function ($get) {
//                    $locale = $get('active_locale') ?: 'en';
//
//                    return 'Title (' . (self::locales()[$locale]) . ')';
//                })
//                ->live()
//                ->afterStateUpdated(function ($state, $set, $get) {
//                    $locale = $get('active_locale') ?: 'en';
//
//                    $titles = $get('title') ?? [];
//                    $titles[$locale] = $state;
//
//                    $set('title', $titles);
//                })
//                ->afterStateHydrated(function ($set, $get) {
//                    $locale = $get('active_locale') ?? 'en';
//                    $titles = $get('title') ?? [];
//
//                    $set('title_input', $titles[$locale] ?? '');
//                }),

            ...TranslatableTextInput::make('title', self::locales()),
//            ...TranslatableTextarea::make('description', self::locales(), 10),
            ...TranslatableRichEditor::make('description', self::locales()),

//            Textarea::make('description')
//                ->label('Description')
//                ->required(),

            Select::make('status')
                ->options(PollStatus::class)
                ->default('draft')
                ->required(),

            \Filament\Forms\Components\Repeater::make('options')
                ->relationship()
                ->schema([
                    \Filament\Forms\Components\TextInput::make('text')
                        ->required(),
                ])
                ->columnSpanFull()
                ->minItems(2)
                ->maxItems(10),

            Hidden::make('user_id')
                ->default(auth()->id()),
        ]);
    }
}
