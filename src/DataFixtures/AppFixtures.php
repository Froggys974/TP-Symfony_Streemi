<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\CategoryMedia;
use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Language;
use App\Entity\Media;
use App\Entity\MediaLanguage;
use App\Entity\Movie;
use App\Entity\Playlist;
use App\Entity\PlaylistMedia;
use App\Entity\Season;
use App\Entity\Serie;
use App\Entity\Subscription;
use App\Entity\SubscriptionHistory;
use App\Entity\User;
use App\Entity\WatchHistory;
use App\Enum\UserAccountStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const NB_USERS = 10;
    private const NB_SUBSCRIPTIONS = 5;
    private const NB_MEDIA = 20;
    private const NB_CATEGORIES = 10;
    private const NB_COMMENTS = 30;
    private const NB_PLAYLISTS = 5;

    private $faker;

    public function __construct()
    {
        // Initialise Faker dans le constructeur
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $categories = $this->loadCategories($manager);
        $users = $this->loadUsers($manager);
        $subscriptions = $this->loadSubscriptions($manager);
        $mediaList = $this->loadMedia($manager);
        $this->loadPlaylists($manager, $mediaList);
        $this->loadComments($manager);
        $this->loadSubscriptionHistory($manager, $users, $subscriptions);
        $this->loadWatchHistory($manager, $users, $mediaList);

        $manager->flush();
    }

    private function loadCategories(ObjectManager $manager): array
    {
        $categories = [];
        for ($i = 0; $i < self::NB_CATEGORIES; $i++) {
            $category = new Category();
            $category->setName($this->faker->word());
            $category->setLabel($this->faker->word());
            $categories[] = $category;
            $manager->persist($category);
        }
        return $categories;
    }

    private function loadUsers(ObjectManager $manager): array
    {
        $users = [];
        for ($i = 0; $i < self::NB_USERS; $i++) {
            $user = new User();
            $user->setUsername($this->faker->userName());
            $user->setEmail($this->faker->email());
            $user->setPassword($this->faker->password());
            $user->setAccountStatus(UserAccountStatusEnum::ACTIVE);
            $users[] = $user;
            $manager->persist($user);
        }
        return $users;
    }

    private function loadSubscriptions(ObjectManager $manager): array
    {
        $subscriptions = [];
        for ($i = 0; $i < self::NB_SUBSCRIPTIONS; $i++) {
            $subscription = new Subscription();
            $subscription->setName($this->faker->word());
            $subscription->setPrice($this->faker->numberBetween(5, 100));
            $subscription->setDuration($this->faker->numberBetween(1, 12)); // en mois
            $subscriptions[] = $subscription;
            $manager->persist($subscription);
        }
        return $subscriptions;
    }

    private function loadMedia(ObjectManager $manager): array
    {
        $mediaList = [];
        for ($i = 0; $i < self::NB_MEDIA; $i++) {
            $media = new Media();
            $media->setTitle($this->faker->sentence(3));
            $media->setShortDescription($this->faker->paragraph());
            $media->setLongDescription($this->faker->text());
            $media->setReleaseDate($this->faker->dateTimeThisDecade());
            $media->setMediaType($this->faker->randomElement(['movie', 'serie', 'documentary']));
            $mediaList[] = $media;
            $manager->persist($media);
        }
        return $mediaList;
    }

    private function loadPlaylists(ObjectManager $manager, array $mediaList): void
    {
        for ($i = 0; $i < self::NB_PLAYLISTS; $i++) {
            $playlist = new Playlist();
            $playlist->setName($this->faker->sentence(2));
            $playlist->setCreatedAt($this->faker->dateTimeThisYear());
            $playlist->setUpdatedAt($this->faker->dateTimeThisYear());

            // Ajouter des médias à la playlist
            for ($j = 0; $j < mt_rand(1, 5); $j++) {
                $playlistMedia = new PlaylistMedia();
                $playlistMedia->setAddedAt($this->faker->dateTimeThisYear());
                $playlist->addPlaylistMedia($playlistMedia);
                $manager->persist($playlistMedia);
            }

            $manager->persist($playlist);
        }
    }

    private function loadComments(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::NB_COMMENTS; $i++) {
            $comment = new Comment();
            $comment->setContent($this->faker->paragraph());
            $comment->setStatusEnum('approved');
            $manager->persist($comment);
        }
    }

    private function loadSubscriptionHistory(ObjectManager $manager, array $users, array $subscriptions): void
    {
        foreach ($users as $user) {
            foreach ($subscriptions as $subscription) {
                $subscriptionHistory = new SubscriptionHistory();
                $subscriptionHistory->setStartDate($this->faker->dateTimeThisYear());
                $subscriptionHistory->setEndDate($this->faker->dateTimeBetween('now', '+1 years'));
                $manager->persist($subscriptionHistory);
            }
        }
    }

    private function loadWatchHistory(ObjectManager $manager, array $users, array $mediaList): void
    {
        foreach ($users as $user) {
            foreach ($mediaList as $media) {
                $watchHistory = new WatchHistory();
                $watchHistory->setLastWatched($this->faker->dateTimeThisYear());
                $watchHistory->setNumberOfViews($this->faker->numberBetween(1, 50));
                $manager->persist($watchHistory);
            }
        }
    }
}
