<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241002135422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media_category (media_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_92D3773EA9FDD75 (media_id), INDEX IDX_92D377312469DE2 (category_id), PRIMARY KEY(media_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, playlist_media_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D782112DA76ED395 (user_id), INDEX IDX_D782112D17421B18 (playlist_media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist_subscription (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, playlist_id INT NOT NULL, INDEX IDX_832940CA76ED395 (user_id), INDEX IDX_832940C6BBD148 (playlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE media_category ADD CONSTRAINT FK_92D3773EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_category ADD CONSTRAINT FK_92D377312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D17421B18 FOREIGN KEY (playlist_media_id) REFERENCES playlist_media (id)');
        $this->addSql('ALTER TABLE playlist_subscription ADD CONSTRAINT FK_832940CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE playlist_subscription ADD CONSTRAINT FK_832940C6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
        $this->addSql('DROP TABLE category_media');
        $this->addSql('DROP TABLE playlists');
        $this->addSql('ALTER TABLE comment ADD user_id INT NOT NULL, ADD media_id INT NOT NULL, ADD parent_comment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CBF2AF943 FOREIGN KEY (parent_comment_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526CEA9FDD75 ON comment (media_id)');
        $this->addSql('CREATE INDEX IDX_9474526CBF2AF943 ON comment (parent_comment_id)');
        $this->addSql('ALTER TABLE episode ADD season_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('CREATE INDEX IDX_DDAA1CDA4EC001D1 ON episode (season_id)');
        $this->addSql('ALTER TABLE media ADD playlist_media_id INT DEFAULT NULL, ADD disc VARCHAR(255) NOT NULL, DROP media_type');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C17421B18 FOREIGN KEY (playlist_media_id) REFERENCES playlist_media (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C17421B18 ON media (playlist_media_id)');
        $this->addSql('ALTER TABLE media_language MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON media_language');
        $this->addSql('ALTER TABLE media_language ADD media_id INT NOT NULL, ADD language_id INT NOT NULL, DROP id');
        $this->addSql('ALTER TABLE media_language ADD CONSTRAINT FK_DBBA5F07EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_language ADD CONSTRAINT FK_DBBA5F0782F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_DBBA5F07EA9FDD75 ON media_language (media_id)');
        $this->addSql('CREATE INDEX IDX_DBBA5F0782F1BAF4 ON media_language (language_id)');
        $this->addSql('ALTER TABLE media_language ADD PRIMARY KEY (media_id, language_id)');
        $this->addSql('ALTER TABLE movie CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FBF396750 FOREIGN KEY (id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE season ADD serie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA9D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('CREATE INDEX IDX_F0E45BA9D94388BD ON season (serie_id)');
        $this->addSql('ALTER TABLE serie CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A9334BF396750 FOREIGN KEY (id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subscription_history ADD user_id INT NOT NULL, ADD subscription_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription_history ADD CONSTRAINT FK_54AF90D0A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE subscription_history ADD CONSTRAINT FK_54AF90D09A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id)');
        $this->addSql('CREATE INDEX IDX_54AF90D0A76ED395 ON subscription_history (user_id)');
        $this->addSql('CREATE INDEX IDX_54AF90D09A1887DC ON subscription_history (subscription_id)');
        $this->addSql('ALTER TABLE user ADD current_subscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DDE45DDE FOREIGN KEY (current_subscription_id) REFERENCES playlist_subscriptions (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649DDE45DDE ON user (current_subscription_id)');
        $this->addSql('ALTER TABLE watch_history ADD user_id INT NOT NULL, ADD media_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE watch_history ADD CONSTRAINT FK_DE44EFD8A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE watch_history ADD CONSTRAINT FK_DE44EFD8EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_DE44EFD8A76ED395 ON watch_history (user_id)');
        $this->addSql('CREATE INDEX IDX_DE44EFD8EA9FDD75 ON watch_history (media_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_media (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE playlists (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE media_category DROP FOREIGN KEY FK_92D3773EA9FDD75');
        $this->addSql('ALTER TABLE media_category DROP FOREIGN KEY FK_92D377312469DE2');
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112DA76ED395');
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D17421B18');
        $this->addSql('ALTER TABLE playlist_subscription DROP FOREIGN KEY FK_832940CA76ED395');
        $this->addSql('ALTER TABLE playlist_subscription DROP FOREIGN KEY FK_832940C6BBD148');
        $this->addSql('DROP TABLE media_category');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_subscription');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CEA9FDD75');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CBF2AF943');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395 ON comment');
        $this->addSql('DROP INDEX IDX_9474526CEA9FDD75 ON comment');
        $this->addSql('DROP INDEX IDX_9474526CBF2AF943 ON comment');
        $this->addSql('ALTER TABLE comment DROP user_id, DROP media_id, DROP parent_comment_id');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA4EC001D1');
        $this->addSql('DROP INDEX IDX_DDAA1CDA4EC001D1 ON episode');
        $this->addSql('ALTER TABLE episode DROP season_id');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C17421B18');
        $this->addSql('DROP INDEX IDX_6A2CA10C17421B18 ON media');
        $this->addSql('ALTER TABLE media ADD media_type VARCHAR(255) DEFAULT NULL, DROP playlist_media_id, DROP disc');
        $this->addSql('ALTER TABLE media_language DROP FOREIGN KEY FK_DBBA5F07EA9FDD75');
        $this->addSql('ALTER TABLE media_language DROP FOREIGN KEY FK_DBBA5F0782F1BAF4');
        $this->addSql('DROP INDEX IDX_DBBA5F07EA9FDD75 ON media_language');
        $this->addSql('DROP INDEX IDX_DBBA5F0782F1BAF4 ON media_language');
        $this->addSql('ALTER TABLE media_language ADD id INT AUTO_INCREMENT NOT NULL, DROP media_id, DROP language_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26FBF396750');
        $this->addSql('ALTER TABLE movie CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE season DROP FOREIGN KEY FK_F0E45BA9D94388BD');
        $this->addSql('DROP INDEX IDX_F0E45BA9D94388BD ON season');
        $this->addSql('ALTER TABLE season DROP serie_id');
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A9334BF396750');
        $this->addSql('ALTER TABLE serie CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE subscription_history DROP FOREIGN KEY FK_54AF90D0A76ED395');
        $this->addSql('ALTER TABLE subscription_history DROP FOREIGN KEY FK_54AF90D09A1887DC');
        $this->addSql('DROP INDEX IDX_54AF90D0A76ED395 ON subscription_history');
        $this->addSql('DROP INDEX IDX_54AF90D09A1887DC ON subscription_history');
        $this->addSql('ALTER TABLE subscription_history DROP user_id, DROP subscription_id');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649DDE45DDE');
        $this->addSql('DROP INDEX IDX_8D93D649DDE45DDE ON `user`');
        $this->addSql('ALTER TABLE `user` DROP current_subscription_id');
        $this->addSql('ALTER TABLE watch_history DROP FOREIGN KEY FK_DE44EFD8A76ED395');
        $this->addSql('ALTER TABLE watch_history DROP FOREIGN KEY FK_DE44EFD8EA9FDD75');
        $this->addSql('DROP INDEX IDX_DE44EFD8A76ED395 ON watch_history');
        $this->addSql('DROP INDEX IDX_DE44EFD8EA9FDD75 ON watch_history');
        $this->addSql('ALTER TABLE watch_history DROP user_id, DROP media_id');
    }
}
