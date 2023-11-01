<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230728112634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'User Information';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD phone_number VARCHAR(255) NOT NULL, CHANGE is_verified is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP nom, DROP prenom, DROP phone_number, CHANGE is_verified is_verified TINYINT(1) DEFAULT NULL');
    }
}
