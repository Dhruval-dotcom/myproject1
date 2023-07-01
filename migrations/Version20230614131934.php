<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614131934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vinyl_mix_tag (vinyl_mix_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_FDAF9A284D0FBAC8 (vinyl_mix_id), INDEX IDX_FDAF9A28BAD26311 (tag_id), PRIMARY KEY(vinyl_mix_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vinyl_mix_tag ADD CONSTRAINT FK_FDAF9A284D0FBAC8 FOREIGN KEY (vinyl_mix_id) REFERENCES vinyl_mix (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vinyl_mix_tag ADD CONSTRAINT FK_FDAF9A28BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vinyl_mix_tag DROP FOREIGN KEY FK_FDAF9A284D0FBAC8');
        $this->addSql('ALTER TABLE vinyl_mix_tag DROP FOREIGN KEY FK_FDAF9A28BAD26311');
        $this->addSql('DROP TABLE vinyl_mix_tag');
    }
}
