<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221228151552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__personnel AS SELECT id, full_name, post, image_name, birthday, created_at FROM personnel');
        $this->addSql('DROP TABLE personnel');
        $this->addSql('CREATE TABLE personnel (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, full_name VARCHAR(80) NOT NULL, post VARCHAR(90) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, birthday DATE DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO personnel (id, full_name, post, image_name, birthday, created_at) SELECT id, full_name, post, image_name, birthday, created_at FROM __temp__personnel');
        $this->addSql('DROP TABLE __temp__personnel');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnel ADD COLUMN detail CLOB NOT NULL');
    }
}
