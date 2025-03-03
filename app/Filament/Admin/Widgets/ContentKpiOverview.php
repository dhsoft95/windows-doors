<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Author;
use App\Models\Product;
use App\Models\Tag;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class ContentKpiOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        return [
            // Content Stats
            Stat::make('Total Articles', Article::count())
                ->description('Total articles in the system')
                ->descriptionIcon('heroicon-o-document-text')
                ->chart($this->getArticlesTrend())
                ->color('primary'),

            Stat::make('Published Articles', Article::whereNotNull('published_at')->count())
                ->description($this->getPublishedArticlesChange())
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->chart($this->getPublishedArticlesTrend())
                ->color('success'),

            Stat::make('Active Authors', Author::active()->count())
                ->description('Content creators')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('info'),

            // Product Stats
            Stat::make('Total Products', Product::count())
                ->description('All products')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->chart($this->getProductsTrend())
                ->color('primary'),

            Stat::make('In-Stock Products', Product::where('is_in_stock', true)->count())
                ->description($this->getStockPercentage() . '% of total')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Featured Products', Product::where('is_featured', true)->count())
                ->description('Highlighted items')
                ->descriptionIcon('heroicon-o-star')
                ->color('warning'),

            // Taxonomy Stats
            Stat::make('Article Categories', ArticleCategory::count())
                ->description('Content organization')
                ->descriptionIcon('heroicon-o-folder')
                ->color('gray'),

            Stat::make('Tags', Tag::count())
                ->description('Content classification')
                ->descriptionIcon('heroicon-o-tag')
                ->color('gray'),

            Stat::make('Avg Products per Category', $this->getAvgProductsPerCategory())
                ->description('Category distribution')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('info'),
        ];
    }

    private function getArticlesTrend(): array
    {
        return $this->getTrendData(Article::class);
    }

    private function getPublishedArticlesTrend(): array
    {
        return $this->getTrendData(Article::class, function($query) {
            return $query->whereNotNull('published_at');
        });
    }

    private function getProductsTrend(): array
    {
        return $this->getTrendData(Product::class);
    }

    private function getTrendData($model, $queryCallback = null)
    {
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->startOfDay();

            $query = $model::where('created_at', '>=', $date)
                ->where('created_at', '<', Carbon::now()->subDays($i - 1)->startOfDay());

            if ($queryCallback) {
                $query = $queryCallback($query);
            }

            $data[] = $query->count();
        }

        return $data;
    }

    private function getPublishedArticlesChange(): string
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        $currentCount = Article::whereNotNull('published_at')
            ->where('published_at', '>=', $currentMonth)
            ->count();

        $lastCount = Article::whereNotNull('published_at')
            ->where('published_at', '>=', $lastMonth)
            ->where('published_at', '<', $currentMonth)
            ->count();

        if ($lastCount === 0) {
            return 'New this month';
        }

        $percentageChange = (($currentCount - $lastCount) / $lastCount) * 100;

        return number_format(abs($percentageChange), 1) . '% ' .
            ($percentageChange >= 0 ? 'increase' : 'decrease') . ' from last month';
    }

    private function getStockPercentage(): int
    {
        $total = Product::count();

        if ($total === 0) {
            return 0;
        }

        $inStock = Product::where('is_in_stock', true)->count();

        return round(($inStock / $total) * 100);
    }

    private function getAvgProductsPerCategory(): string
    {
        $categoryCount = \App\Models\ProductCategory::count();

        if ($categoryCount === 0) {
            return '0';
        }

        $productCount = Product::count();

        return number_format($productCount / $categoryCount, 1);
    }
}
