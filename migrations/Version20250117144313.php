<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250117144313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD slug VARCHAR(255)');
+        $this->addSql("UPDATE book SET slug=CONCAT(LOWER(title), '-', LOWER(author));");
+        $this->addSql('ALTER TABLE book ALTER COLUMN slug SET NOT NULL');
        $this->addSql('ALTER TABLE book ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CBE5A331989D9B62 ON book (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_CBE5A331989D9B62');
        $this->addSql('ALTER TABLE book DROP slug');
        $this->addSql('ALTER TABLE book ALTER created_at SET DEFAULT \'2025-01-17 14:10:16.027778\'');
    }
}
