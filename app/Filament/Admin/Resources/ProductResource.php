<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Filament\Admin\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\ImagesRelationManager;
use App\Models\Product;
use App\Models\ProductCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Shop Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string
    {
        return static::getModel()::where('is_active', true)->count() > 0 ? 'success' : 'gray';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug', 'short_description', 'category.name', 'sku'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Basic Information')
                            ->description('Enter the essential product details')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Select::make('product_category_id')
                                    ->label('Category')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(true)
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Active')
                                            ->default(true),
                                    ]),

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
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Used for the product URL. Auto-generated from name.'),
                                Forms\Components\Toggle::make('is_door')
                                    ->label('Simba Door Product')
                                    ->helperText('Mark this product as part of the Simba Doors Collection')
                                    ->default(false)
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state, Forms\Get $get) {
                                        if ($state) {
                                            $set('is_featured', true);

                                            // Get the Simba doors category ID dynamically
                                            $doorCategoryId =ProductCategory::where('slug', 'simba-doors-collections')
                                                ->first()?->id;

                                            if ($doorCategoryId) {
                                                $set('product_category_id', $doorCategoryId);
                                            }
                                        }
                                    })
                                    ->hint('Simba Doors require specific measurements and installation details')

                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('short_description')
                                    ->maxLength(255)
                                    ->helperText('Brief description for product listings and search results (max 255 characters)')
                                    ->columnSpanFull(),

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
                            ])
                            ->columns(2),
                        Forms\Components\Section::make('Product Features')
                            ->description('List key benefits and features of the product')
                            ->icon('heroicon-o-star')
                            ->collapsible()
                            ->schema([
                                Forms\Components\Repeater::make('features')
                                    ->relationship('features')
                                    ->schema([
                                        Forms\Components\TagsInput::make('features')
                                            ->required()
                                            ->placeholder('Add multiple features like "Water-resistant", "Eco-friendly"'),
                                        Forms\Components\Hidden::make('sort_order')
                                            ->default(fn (Forms\Get $get) => $get('../../features') ? count($get('../../features')) + 1 : 1),
                                    ])
                                    ->itemLabel(fn (array $state): ?string =>
                                    is_array($state['features'])
                                        ? implode(', ', array_slice($state['features'], 0, 2)) . (count($state['features']) > 2 ? '...' : '')
                                        : $state['features'] ?? null
                                    )
                                    ->addActionLabel('Add Feature Group')
                                    ->reorderableWithButtons()
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Section::make('Related Products')
                            ->description('Suggest additional products to customers')
                            ->icon('heroicon-o-squares-plus')
                            ->collapsible()
                            ->schema([
                                Forms\Components\Select::make('relatedProducts')
                                    ->label('Select Related Products')
                                    ->relationship('relatedProducts', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->searchable()
                                    ->helperText('Products that will be shown as related to this one')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status & Visibility')
                            ->icon('heroicon-o-eye')
                            ->schema([
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Featured Product')
                                    ->helperText('Show this product on the homepage')
                                    ->default(false),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active')
                                    ->helperText('Inactive products are not shown to customers')
                                    ->default(true),

                                Forms\Components\TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Lower numbers appear first'),

                                Forms\Components\DatePicker::make('published_at')
                                    ->label('Publishing Date')
                                    ->helperText('Leave empty to publish immediately'),
                            ]),

                        Forms\Components\Section::make('Main Image')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('main_image')
                                    ->image()
                                    ->directory('products')
                                    ->required()
                                    ->imagePreviewHeight('250')
                                    ->imageResizeMode('cover')
                                    ->imageEditor()
                                    ->helperText('Rectangular image recommended (1:2 ratio)'), // Updated helper text to match the ratio
                            ]),

                        Forms\Components\Section::make('Tags')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                Forms\Components\Select::make('tags')
                                    ->relationship('tags', 'name')
                                    ->multiple()
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
                                            ->unique('tags', 'slug', ignoreRecord: true),
                                    ])
                                    ->helperText('Assign tags to help customers find this product'),
                            ]),

                        Forms\Components\Section::make('Metadata')
                            ->icon('heroicon-o-document-text')
                            ->collapsible()
                            ->schema([
                                Forms\Components\TextInput::make('meta_title')
                                    ->helperText('Leave empty to use product name')
                                    ->maxLength(60),
                                Forms\Components\Textarea::make('meta_description')
                                    ->helperText('For SEO purposes - max 160 characters')
                                    ->maxLength(500),
                                Forms\Components\TagsInput::make('keywords')
                                    ->helperText('Press Enter to add a keyword'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('main_image')
                    ->label('Image')
                    ->square()
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

                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->sortable()
                    ->toggleable(),

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

                Tables\Columns\IconColumn::make('is_in_stock')
                    ->label('In Stock')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('sort_order')
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
//            ->filters([
//                Tables\Filters\SelectFilter::make('product_category_id')
//                    ->label('Category')
//                    ->relationship('category', 'name')
//                    ->multiple()
//                    ->searchable()
//                    ->preload(),
//
//                Tables\Filters\TernaryFilter::make('is_featured')
//                    ->label('Featured')
//                    ->indicator('Featured Products'),
//
//                Tables\Filters\TernaryFilter::make('is_active')
//                    ->label('Active')
//                    ->trueLabel('Active Products')
//                    ->falseLabel('Inactive Products')
//                    ->indicator('Status'),
//
//                Tables\Filters\TernaryFilter::make('is_in_stock')
//                    ->label('Stock Status')
//                    ->trueLabel('In Stock')
//                    ->falseLabel('Out of Stock')
//                    ->indicator('Stock'),
//
//                Filter::make('on_sale')
//                    ->label('On Sale')
//                    ->query(function (Builder $query): Builder {
//                        return $query
//                            ->whereNotNull('sale_price')
//                            ->where('sale_price', '>', 0)
//                            ->where('sale_price', '<', new \Illuminate\Database\Query\Expression('price'));
//                    })
//                    ->indicator('On Sale'),
//
//                Filter::make('price_range')
//                    ->form([
//                        Forms\Components\Grid::make(2)
//                            ->schema([
//                                Forms\Components\TextInput::make('min_price')
//                                    ->label('Min Price')
//                                    ->numeric()
//                                    ->placeholder('0'),
//                                Forms\Components\TextInput::make('max_price')
//                                    ->label('Max Price')
//                                    ->numeric()
//                                    ->placeholder('999999'),
//                            ]),
//                    ])
//                    ->query(function (Builder $query, array $data): Builder {
//                        return $query
//                            ->when(
//                                $data['min_price'] ?? null,
//                                fn (Builder $query, $price) => $query->where('price', '>=', $price)
//                            )
//                            ->when(
//                                $data['max_price'] ?? null,
//                                fn (Builder $query, $price) => $query->where('price', '<=', $price)
//                            );
//                    })
//                    ->indicateUsing(function (array $data): array {
//                        $indicators = [];
//
//                        if ($data['min_price'] ?? null) {
//                            $indicators[] = Indicator::make('Min Price: $' . number_format($data['min_price'], 2))
//                                ->removeField('min_price');
//                        }
//
//                        if ($data['max_price'] ?? null) {
//                            $indicators[] = Indicator::make('Max Price: $' . number_format($data['max_price'], 2))
//                                ->removeField('max_price');
//                        }
//
//                        return $indicators;
//                    })
//            ], layout: FiltersLayout::AboveContent)
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
                        ->action(function (Product $record) {
                            // Generate unique SKU
                            $baseSku = $record->sku;
                            $skuCounter = 1;
                            do {
                                $newSku = $baseSku . '-' . $skuCounter;
                                $existingSku = Product::where('sku', $newSku)->first();
                                $skuCounter++;
                            } while ($existingSku);

                            // Generate unique slug
                            $baseName = $record->name . ' (Copy)';
                            $baseSlug = Str::slug($baseName);
                            $slugCounter = 1;
                            do {
                                $newSlug = $slugCounter > 1
                                    ? $baseSlug . '-' . $slugCounter
                                    : $baseSlug;
                                $existingSlug = Product::where('slug', $newSlug)->first();
                                $slugCounter++;
                            } while ($existingSlug);

                            $duplicate = $record->replicate(['features', 'specifications', 'relatedProducts', 'tags']);
                            $duplicate->name = $baseName;
                            $duplicate->slug = $newSlug;
                            $duplicate->sku = $newSku;
                            $duplicate->save();

                            // Copy relationships
                            foreach ($record->features as $feature) {
                                $duplicate->features()->create([
                                    'product_id' => $duplicate->id,
                                    'features' => $feature->features, // Use 'features' column
                                    'sort_order' => $feature->sort_order,
                                ]);
                            }

                            foreach ($record->specifications as $spec) {
                                $duplicate->specifications()->create([
                                    'product_id' => $duplicate->id,
                                    'label' => $spec->label,
                                    'value' => $spec->value,
                                    'sort_order' => $spec->sort_order,
                                ]);
                            }

                            $duplicate->tags()->sync($record->tags->pluck('id'));
                            $duplicate->relatedProducts()->sync($record->relatedProducts->pluck('id'));

                            return $duplicate;
                        }),
                    Tables\Actions\Action::make('toggleFeatured')
                        ->label(fn (Product $record): string => $record->is_featured ? 'Unfeature' : 'Feature')
                        ->icon('heroicon-o-star')
                        ->color(fn (Product $record): string => $record->is_featured ? 'gray' : 'warning')
                        ->action(function (Product $record): void {
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
                    Tables\Actions\BulkAction::make('toggleStock')
                        ->label('Toggle Stock Status')
                        ->icon('heroicon-o-cube')
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->is_in_stock = !$record->is_in_stock;
                                if (!$record->is_in_stock) {
                                    $record->stock_quantity = 0;
                                } elseif ($record->stock_quantity == 0) {
                                    $record->stock_quantity = 1;
                                }
                                $record->save();
                            }
                        }),
                    Tables\Actions\BulkAction::make('exportProducts')
                        ->label('Export Selected')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(function (Collection $records): void {
                            // Add export functionality here
                        }),
                ]),
            ])
            ->defaultSort('sort_order')
            ->persistSortInSession();
    }

    public static function getRelations(): array
    {
        return [
        ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
