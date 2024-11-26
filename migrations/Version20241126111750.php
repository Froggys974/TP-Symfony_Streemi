<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241126111750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C17421B18');
        $this->addSql('DROP INDEX IDX_6A2CA10C17421B18 ON media');
        $this->addSql('ALTER TABLE media DROP playlist_media_id');
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D17421B18');
        $this->addSql('DROP INDEX IDX_D782112D17421B18 ON playlist');
        $this->addSql('ALTER TABLE playlist DROP playlist_media_id');
        $this->addSql('ALTER TABLE playlist_media ADD playlist_id INT NOT NULL, ADD media_id INT NOT NULL');
        $this->addSql('ALTER TABLE playlist_media ADD CONSTRAINT FK_C930B84F6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE playlist_media ADD CONSTRAINT FK_C930B84FEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_C930B84F6BBD148 ON playlist_media (playlist_id)');
        $this->addSql('CREATE INDEX IDX_C930B84FEA9FDD75 ON playlist_media (media_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media ADD playlist_media_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C17421B18 FOREIGN KEY (playlist_media_id) REFERENCES playlist_media (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C17421B18 ON media (playlist_media_id)');
        $this->addSql('ALTER TABLE playlist ADD playlist_media_id INT NOT NULL');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D17421B18 FOREIGN KEY (playlist_media_id) REFERENCES playlist_media (id)');
        $this->addSql('CREATE INDEX IDX_D782112D17421B18 ON playlist (playlist_media_id)');
        $this->addSql('ALTER TABLE playlist_media DROP FOREIGN KEY FK_C930B84F6BBD148');
        $this->addSql('ALTER TABLE playlist_media DROP FOREIGN KEY FK_C930B84FEA9FDD75');
        $this->addSql('DROP INDEX IDX_C930B84F6BBD148 ON playlist_media');
        $this->addSql('DROP INDEX IDX_C930B84FEA9FDD75 ON playlist_media');
        $this->addSql('ALTER TABLE playlist_media DROP playlist_id, DROP media_id');
    }
}
