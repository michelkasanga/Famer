<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221227153751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__testimonial AS SELECT id, full_name, title, image_name, message, created_at FROM testimonial');
        $this->addSql('DROP TABLE testimonial');
        $this->addSql('CREATE TABLE testimonial (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, full_name VARCHAR(180) NOT NULL, title VARCHAR(180) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, message CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO testimonial (id, full_name, title, image_name, message, created_at) SELECT id, full_name, title, image_name, message, created_at FROM __temp__testimonial');
        $this->addSql('DROP TABLE __temp__testimonial');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE testimonial ADD COLUMN stars INTEGER NOT NULL');
    }
}
