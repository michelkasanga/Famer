<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221225130002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__about AS SELECT id, contact, detail, created_at, image_name FROM about');
        $this->addSql('DROP TABLE about');
        $this->addSql('CREATE TABLE about (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact INTEGER NOT NULL, detail CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , image_name VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO about (id, contact, detail, created_at, image_name) SELECT id, contact, detail, created_at, image_name FROM __temp__about');
        $this->addSql('DROP TABLE __temp__about');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about ADD COLUMN video CLOB DEFAULT NULL');
    }
}
