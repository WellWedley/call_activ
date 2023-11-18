<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231117113932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE squad ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE squad ADD CONSTRAINT FK_CFD0FFE77E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CFD0FFE77E3C61F9 ON squad (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE squad DROP FOREIGN KEY FK_CFD0FFE77E3C61F9');
        $this->addSql('DROP INDEX IDX_CFD0FFE77E3C61F9 ON squad');
        $this->addSql('ALTER TABLE squad DROP owner_id');
    }
}
