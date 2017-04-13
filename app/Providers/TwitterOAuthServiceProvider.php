<?php

namespace App\Providers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Flintstone\Flintstone;
use Illuminate\Support\ServiceProvider;
use Santik\RecruitzIoTwitter\Domain\TweetReachDecider;
use Santik\RecruitzIoTwitter\Infrastructure\ApiTwitterDataResolver;
use Santik\RecruitzIoTwitter\Infrastructure\FileTwitterReachDatabaseAdapter;
use Santik\RecruitzIoTwitter\TwitterService;

class TwitterOAuthServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app ?: app();
        $config = $app['config']['twitter'];

        $twitterOAuth = new TwitterOAuth($config['CONSUMER_KEY'], $config['CONSUMER_SECRET'], $config['ACCESS_TOKEN'], $config['ACCESS_TOKEN_SECRET']);
        $twitterDataResolver = new ApiTwitterDataResolver($twitterOAuth);

        $options = array('dir' => __DIR__ . '/../../storage/database');
        $tweets = new Flintstone('tweets', $options);
        $database = new FileTwitterReachDatabaseAdapter($tweets);

        $this->app->singleton(TwitterService::class, function () use ($twitterDataResolver, $database) {
            return new TwitterService($twitterDataResolver, $database, new TweetReachDecider());
        });

    }
}