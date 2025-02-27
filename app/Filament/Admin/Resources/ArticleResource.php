<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ArticleResource\Pages;
use App\Filament\Admin\Resources\ArticleResource\RelationManagers;
use App\Filament\Resources\ArticleCategoryResource\RelationManagers\ArticlesRelationManager;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Collection;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{

    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'excerpt', 'content', 'author.name', 'category.name'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Article Content')
                            ->description('Enter the main content for this article')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                        if ($operation === 'create') {
                                            $set('slug', Str::slug($state));
                                            $set('meta_title', $state);
                                        }
                                    }),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Article::class, 'slug', ignoreRecord: true)
                                    ->helperText('The URL-friendly version of the name'),

                                Forms\Components\Textarea::make('excerpt')
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->helperText('A brief summary of the article (max 500 characters)')
                                    ->columnSpanFull(),

                                Forms\Components\RichEditor::make('content')
                                    ->required()
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('articles/attachments')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make('Article Meta')
                            ->description('Additional information and metadata')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                Forms\Components\Select::make('article_category_id')
                                    ->label('Category')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(debounce: 500)
                                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                                if ($operation === 'create') {
                                                    $set('slug', Str::slug($state));
                                                }
                                            }),
                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique('article_categories', 'slug'),
                                    ]),

                                Forms\Components\Select::make('author_id')
                                    ->label('Author')
                                    ->relationship('author', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(debounce: 500)
                                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                                if ($operation === 'create') {
                                                    $set('slug', Str::slug($state));
                                                }
                                            }),
                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique('authors', 'slug'),
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->maxLength(255)
                                            ->unique('authors', 'email'),
                                    ]),

                                Forms\Components\Select::make('tags')
                                    ->relationship('tags', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(debounce: 500)
                                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                                if ($operation === 'create') {
                                                    $set('slug', Str::slug($state));
                                                }
                                            }),
                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique('tags', 'slug'),
                                    ]),

                                Forms\Components\TextInput::make('reading_time')
                                    ->label('Reading Time (minutes)')
                                    ->numeric()
                                    ->minValue(1)
                                    ->default(5)
                                    ->helperText('Estimated reading time in minutes')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Publishing')
                            ->icon('heroicon-o-clock')
                            ->schema([
                                Forms\Components\Toggle::make('is_published')
                                    ->label('Published')
                                    ->helperText('When enabled, the article will be visible to readers')
                                    ->default(false),

                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Publish Date & Time')
                                    ->helperText('Schedule when this article should be published')
                                    ->default(now()),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Featured Article')
                                    ->helperText('Feature this article on the homepage')
                                    ->default(false),
                            ]),

                        Forms\Components\Section::make('Featured Image')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('featured_image')
                                    ->image()
                                    ->directory('articles/featured')
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('1200')
                                    ->imageResizeTargetHeight('675')
                                    ->imageEditor()
                                    ->helperText('Recommended size: 1200×675 pixels (16:9 ratio)'),
                            ]),

                        Forms\Components\Section::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->collapsible()
                            ->schema([
                                Forms\Components\TextInput::make('meta_title')
                                    ->label('Meta Title')
                                    ->maxLength(60)
                                    ->helperText('Leave empty to use the article title'),

                                Forms\Components\Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->maxLength(160)
                                    ->helperText('Ideal length is 150-160 characters'),

                                Forms\Components\TagsInput::make('keywords')
                                    ->helperText('Press Enter to add a keyword'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Article Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('title')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                            ->weight(FontWeight::Bold)
                            ->columnSpanFull(),

                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('author.name')
                                    ->label('Author'),

                                Infolists\Components\TextEntry::make('category.name')
                                    ->label('Category')
                                    ->badge(),
                            ]),

                        Infolists\Components\ImageEntry::make('featured_image')
                            ->label('Featured Image')
                            ->height(300)
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('excerpt')
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('content')
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Grid::make(2)
                    ->schema([
                        Infolists\Components\Section::make('Publishing Details')
                            ->schema([
                                Infolists\Components\TextEntry::make('published_at')
                                    ->label('Published On')
                                    ->dateTime(),

                                Infolists\Components\IconEntry::make('is_published')
                                    ->label('Published')
                                    ->icon(fn (bool $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'),

                                Infolists\Components\IconEntry::make('is_featured')
                                    ->label('Featured')
                                    ->icon(fn (bool $state): string => $state ? 'heroicon-o-star' : 'heroicon-o-x-mark')
                                    ->color(fn (bool $state): string => $state ? 'warning' : 'gray'),

                                Infolists\Components\TextEntry::make('reading_time')
                                    ->label('Reading Time')
                                    ->formatStateUsing(fn ($state) => $state . ' min read'),

                                Infolists\Components\TextEntry::make('view_count')
                                    ->label('Views')
                                    ->formatStateUsing(fn ($state) => number_format($state)),
                            ]),

                        Infolists\Components\Section::make('Metadata')
                            ->schema([
                                Infolists\Components\TextEntry::make('slug')
                                    ->label('URL Slug'),

                                Infolists\Components\TextEntry::make('meta_title')
                                    ->label('Meta Title'),

                                Infolists\Components\TextEntry::make('meta_description')
                                    ->label('Meta Description'),

//                                TagsEntry::make('keywords')
//                                    ->label('Keywords'),
                            ]),
                    ]),

                Infolists\Components\Section::make('Tags')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('tags')
                            ->schema([
                                Infolists\Components\TextEntry::make('name'),
                            ]),
                    ])
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Image')
                    ->width(100)
                    ->height(56)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('warning')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publish Date')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('view_count')
                    ->label('Views')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('article_category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('author_id')
                    ->label('Author')
                    ->relationship('author', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published')
                    ->indicator('Publication Status'),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->indicator('Featured Articles'),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\Action::make('duplicate')
                        ->label('Duplicate')
                        ->icon('heroicon-o-document-duplicate')
                        ->color('gray')
                        ->requiresConfirmation()
                        ->action(function (Article $record) {
                            $duplicate = $record->replicate();
                            $duplicate->title = $duplicate->title . ' (Copy)';
                            $duplicate->slug = Str::slug($duplicate->title);
                            $duplicate->is_published = false;
                            $duplicate->view_count = 0;
                            $duplicate->created_at = now();
                            $duplicate->save();

                            // Copy relationships
                            $duplicate->tags()->sync($record->tags->pluck('id'));
                        }),
                    Tables\Actions\Action::make('togglePublished')
                        ->label(fn (Article $record): string => $record->is_published ? 'Unpublish' : 'Publish')
                        ->icon(fn (Article $record): string => $record->is_published ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                        ->color(fn (Article $record): string => $record->is_published ? 'gray' : 'success')
                        ->action(function (Article $record): void {
                            $record->is_published = !$record->is_published;

                            if ($record->is_published && !$record->published_at) {
                                $record->published_at = now();
                            }

                            $record->save();
                        }),
                    Tables\Actions\Action::make('toggleFeatured')
                        ->label(fn (Article $record): string => $record->is_featured ? 'Unfeature' : 'Feature')
                        ->icon('heroicon-o-star')
                        ->color(fn (Article $record): string => $record->is_featured ? 'gray' : 'warning')
                        ->action(function (Article $record): void {
                            $record->is_featured = !$record->is_featured;
                            $record->save();
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publishSelected')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-eye')
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->is_published = true;

                                if (!$record->published_at) {
                                    $record->published_at = now();
                                }

                                $record->save();
                            }
                        }),
                    Tables\Actions\BulkAction::make('unpublishSelected')
                        ->label('Unpublish Selected')
                        ->icon('heroicon-o-eye-slash')
                        ->color('gray')
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->is_published = false;
                                $record->save();
                            }
                        }),
                    Tables\Actions\BulkAction::make('toggleFeatured')
                        ->label('Toggle Featured Status')
                        ->icon('heroicon-o-star')
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->is_featured = !$record->is_featured;
                                $record->save();
                            }
                        }),
                    Tables\Actions\BulkAction::make('calculateReadingTime')
                        ->label('Calculate Reading Time')
                        ->icon('heroicon-o-clock')
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->calculateReadingTime()->save();
                            }
                        }),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
//            RelatedArticlesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
