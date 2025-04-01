<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductCategoryResource\Pages;
use App\Filament\Admin\Resources\ProductCategoryResource\RelationManagers;
use App\Filament\Resources\ProductCategoryResource\RelationManagers\ProductsRelationManager;
use App\Models\ProductCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Notifications\Collection;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Enums\FiltersLayout;
use App\Filament\Admin\Resources\ProductCategoryResource\RelationManagers\SubcategoriesRelationManager;

class ProductCategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Shop Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug', 'description'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Basic Information')
                            ->description('Enter the essential category details')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Select::make('parent_id')
                                    ->label('Parent Category')
                                    ->relationship('parent', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->nullable()
                                    ->helperText('Leave empty to create a top-level category'),

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
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->helperText('Used for the category URL. Auto-generated from name.'),

                                Forms\Components\RichEditor::make('description')
                                    ->required()
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('products/attachments')
                                    ->toolbarButtons([
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'undo',
                                    ])
                                    ->columnSpanFull(),

                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->directory('product-categories')
                                    ->imageEditor()
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('1200')
                                    ->imageResizeTargetHeight('675')
                                    ->helperText('Recommended size: 1200×675 pixels (16:9 ratio)')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make('Display Options')
                            ->description('Configure how this category appears on the website')
                            ->icon('heroicon-o-presentation-chart-line')
                            ->schema([
                                Forms\Components\Select::make('display_mode')
                                    ->options([
                                        'products' => 'Products Only',
                                        'subcategories' => 'Subcategories Only',
                                        'both' => 'Products & Subcategories',
                                    ])
                                    ->default('products')
                                    ->helperText('How to display this category on the frontend'),

                                Forms\Components\Select::make('products_per_page')
                                    ->options([
                                        12 => '12 products',
                                        24 => '24 products',
                                        36 => '36 products',
                                        48 => '48 products',
                                    ])
                                    ->default(24)
                                    ->helperText('Number of products to display per page'),
                            ])
                            ->columns(2)
                            ->collapsible(),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status & Visibility')
                            ->icon('heroicon-o-eye')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active')
                                    ->helperText('Inactive categories are not shown to customers')
                                    ->default(true)
                                    ->required(),

                                Forms\Components\TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Lower numbers appear first'),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Featured Category')
                                    ->helperText('Show this category on the homepage')
                                    ->default(false),
                            ]),

                        Forms\Components\Section::make('Metadata')
                            ->icon('heroicon-o-document-text')
                            ->collapsible()
                            ->schema([
                                Forms\Components\TextInput::make('meta_title')
                                    ->helperText('Leave empty to use category name')
                                    ->maxLength(60),

                                Forms\Components\Textarea::make('meta_description')
                                    ->helperText('For SEO purposes - max 160 characters')
                                    ->maxLength(160),

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
                Section::make('Category Details')
                    ->schema([
                        TextEntry::make('name')
                            ->size(TextEntrySize::Large)
                            ->weight(FontWeight::Bold),

                        TextEntry::make('slug')
                            ->label('URL Slug'),

                        TextEntry::make('parent.name')
                            ->label('Parent Category')
                            ->visible(fn ($record) => $record->isSubcategory()),

                        ImageEntry::make('image')
                            ->width(800)
                            ->height(450),

                        TextEntry::make('description')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Grid::make(2)
                    ->schema([
                        Section::make('Status')
                            ->schema([
                                IconEntry::make('is_active')
                                    ->label('Active')
                                    ->icon(fn (bool $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'),

                                IconEntry::make('is_featured')
                                    ->label('Featured')
                                    ->icon(fn (bool $state): string => $state ? 'heroicon-o-star' : 'heroicon-o-x-mark')
                                    ->color(fn (bool $state): string => $state ? 'warning' : 'gray'),

                                TextEntry::make('sort_order')
                                    ->label('Sort Order'),
                            ]),

                        Section::make('Display Settings')
                            ->schema([
                                TextEntry::make('display_mode')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state): string => match($state) {
                                        'products' => 'Products Only',
                                        'subcategories' => 'Subcategories Only',
                                        'both' => 'Products & Subcategories',
                                        default => $state,
                                    }),

                                TextEntry::make('products_per_page')
                                    ->formatStateUsing(fn ($state): string => $state . ' products per page'),
                            ]),
                    ]),

                Section::make('Category Statistics')
                    ->schema([
                        TextEntry::make('subcategories_count')
                            ->state(fn (ProductCategory $record): int => $record->subcategories()->count())
                            ->label('Subcategories'),

                        TextEntry::make('products_count')
                            ->state(fn (ProductCategory $record): int => $record->products()->count())
                            ->label('Direct Products'),

                        TextEntry::make('all_products_count')
                            ->state(fn (ProductCategory $record): int => $record->getAllProducts()->count())
                            ->label('Total Products (Including Subcategories)')
                            ->columnSpanFull(),

                        TextEntry::make('active_products_count')
                            ->state(fn (ProductCategory $record): int => $record->products()->where('is_active', true)->count())
                            ->label('Active Products'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->height(40)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('name')
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

                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Parent Category')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('subcategories_count')
                    ->counts('subcategories')
                    ->label('Subcategories')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Products')
                    ->badge()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('warning')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),

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
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Category Level')
                    ->options([
                        '' => 'All Categories',
                        'root' => 'Top-Level Categories Only',
                        'sub' => 'Subcategories Only',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['value'] === 'root', function (Builder $query) {
                            return $query->whereNull('parent_id');
                        })->when($data['value'] === 'sub', function (Builder $query) {
                            return $query->whereNotNull('parent_id');
                        });
                    }),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->trueLabel('Active Categories')
                    ->falseLabel('Inactive Categories')
                    ->indicator('Status'),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->indicator('Featured Categories'),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->before(function (ProductCategory $record, Tables\Actions\DeleteAction $action) {
                            if ($record->products()->count() > 0) {
                                $action->cancel();
                                $action->failureNotification()?->title('Cannot delete category with products');
                            }

                            if ($record->subcategories()->count() > 0) {
                                $action->cancel();
                                $action->failureNotification()?->title('Cannot delete category with subcategories');
                            }
                        }),
                    Tables\Actions\Action::make('duplicate')
                        ->label('Duplicate')
                        ->icon('heroicon-o-document-duplicate')
                        ->color('gray')
                        ->requiresConfirmation()
                        ->action(function (ProductCategory $record) {
                            // Generate unique slug
                            $baseName = $record->name . ' (Copy)';
                            $baseSlug = Str::slug($baseName);
                            $slugCounter = 1;
                            do {
                                $newSlug = $slugCounter > 1
                                    ? $baseSlug . '-' . $slugCounter
                                    : $baseSlug;
                                $existingSlug = ProductCategory::where('slug', $newSlug)->first();
                                $slugCounter++;
                            } while ($existingSlug);

                            // Replicate with specific attributes, excluding system-generated or auto-calculated fields
                            $duplicate = $record->replicate([
                                'products_count',
                                'created_at',
                                'updated_at'
                            ]);

                            $duplicate->name = $baseName;
                            $duplicate->slug = $newSlug;
                            $duplicate->save();

                            return $duplicate;
                        }),
                    Tables\Actions\Action::make('addSubcategory')
                        ->label('Add Subcategory')
                        ->icon('heroicon-o-plus-circle')
                        ->color('success')
                        ->url(fn (ProductCategory $record) =>
                            ProductCategoryResource::getUrl('create') . '?parent_id=' . $record->id)
                        ->openUrlInNewTab(),
                    Tables\Actions\Action::make('toggleFeatured')
                        ->label(fn (ProductCategory $record): string => $record->is_featured ? 'Unfeature' : 'Feature')
                        ->icon('heroicon-o-star')
                        ->color(fn (ProductCategory $record): string => $record->is_featured ? 'gray' : 'warning')
                        ->action(function (ProductCategory $record): void {
                            $record->is_featured = !$record->is_featured;
                            $record->save();
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('toggleFeatured')
                        ->label('Toggle Featured Status')
                        ->icon('heroicon-o-star')
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->is_featured = !$record->is_featured;
                                $record->save();
                            }
                        }),
                    Tables\Actions\BulkAction::make('toggleActive')
                        ->label('Toggle Active Status')
                        ->icon('heroicon-o-eye')
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->is_active = !$record->is_active;
                                $record->save();
                            }
                        }),
                ]),
            ])
            ->defaultSort('sort_order')
            ->persistSortInSession()
            ->modifyQueryUsing(fn (Builder $query) => $query->withCount(['products', 'subcategories']));
    }

    public static function getRelations(): array
    {
        return [
            ProductsRelationManager::class,
            SubcategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductCategories::route('/'),
            'create' => Pages\CreateProductCategory::route('/create'),
            'edit' => Pages\EditProductCategory::route('/{record}/edit'),
        ];
    }
}
