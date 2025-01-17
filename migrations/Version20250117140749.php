<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250117140749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD user_name_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331291A82DC FOREIGN KEY (user_name_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CBE5A331291A82DC ON book (user_name_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A331291A82DC');
        $this->addSql('DROP INDEX IDX_CBE5A331291A82DC');
        $this->addSql('ALTER TABLE book DROP user_name_id');
        $this->addSql('ALTER TABLE book ALTER created_at SET DEFAULT \'2025-01-17 10:56:36.481439\'');
    }
}
