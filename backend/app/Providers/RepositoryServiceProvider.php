<?php
/**
 * Created by PhpStorm.
 * User: rafaelignacio
 * Date: 12/01/16
 * Time: 21:04
 */

namespace MLTools\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            'MLTools\Contracts\IUserRepository',
            'MLTools\Repositories\Eloquent\UserRepository'
        );

        $this->app->bind(
            'MLTools\Contracts\ITaskRepository',
            'MLTools\Repositories\Eloquent\TaskRepository'
        );

        $this->app->bind(
            'MLTools\Contracts\INotificationRepository',
            'MLTools\Repositories\Eloquent\NotificationRepository'
        );

        $this->app->bind(
            'MLTools\Contracts\IAdvertRepository',
            'MLTools\Repositories\Eloquent\AdvertRepository'
        );
    }

}