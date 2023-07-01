<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613050632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE table_two ADD question_id INT NOT NULL');
        $this->addSql('ALTER TABLE table_two ADD CONSTRAINT FK_182F00021E27F6BF FOREIGN KEY (question_id) REFERENCES vinyl_mix (id)');
        $this->addSql('CREATE INDEX IDX_182F00021E27F6BF ON table_two (question_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE table_two DROP FOREIGN KEY FK_182F00021E27F6BF');
        $this->addSql('DROP INDEX IDX_182F00021E27F6BF ON table_two');
        $this->addSql('ALTER TABLE table_two DROP question_id');
    }
}
