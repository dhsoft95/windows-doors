<?php

namespace App\Filament\Admin\Resources\ProductCategoryResource\Pages;

use App\Filament\Admin\Resources\ProductCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;

class ListProductCategories extends ListRecords
{
    protected static string $resource = ProductCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Categories'),
            'top-level' => Tab::make('Top-level Categories')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('parent_id')),
            'subcategories' => Tab::make('Subcategories')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('parent_id')),
            'featured' => Tab::make('Featured')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_featured', true)),
            'inactive' => Tab::make('Inactive')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', false)),
        ];
    }

//    protected function getDefaultActiveTab(): string|int|null
//    {
//        return 'all';
//    }
}
