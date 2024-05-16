<?php

namespace App\Providers;

use App\Repositories\Admin\PromoCreationRepositoryInterface;
use App\Repositories\Admin\PromotionCreationRepository;
use App\Repositories\User\OrderRepository;
use App\Repositories\User\OrderRepositoryInterface;
use App\Repositories\User\PromotionValidityRepository;
use App\Repositories\User\PromoValidityRepoInterface;
use App\Services\Admin\PromoCreationInterface;
use App\Services\Admin\PromotionCreationService;
use App\Services\User\OrderService;
use App\Services\User\OrderServiceInterface;
use App\Services\User\PromotionValidationInterface;
use App\Services\User\PromotionValidationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        $this->app->bind(PromoCreationInterface::class, PromotionCreationService::class);
        $this->app->bind(PromotionValidationInterface::class, PromotionValidationService::class);
        $this->app->bind(PromoCreationRepositoryInterface::class, PromotionCreationRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(PromoValidityRepoInterface::class, PromotionValidityRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
