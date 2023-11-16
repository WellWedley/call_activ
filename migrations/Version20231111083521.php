<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231111083521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE friends (id INT AUTO_INCREMENT NOT NULL, friendship_start DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE friends_user (friends_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_48FBBB49CA8337 (friends_id), INDEX IDX_48FBBBA76ED395 (user_id), PRIMARY KEY(friends_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE friends_user ADD CONSTRAINT FK_48FBBB49CA8337 FOREIGN KEY (friends_id) REFERENCES friends (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE friends_user ADD CONSTRAINT FK_48FBBBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE friends_user DROP FOREIGN KEY FK_48FBBB49CA8337');
        $this->addSql('ALTER TABLE friends_user DROP FOREIGN KEY FK_48FBBBA76ED395');
        $this->addSql('DROP TABLE friends');
        $this->addSql('DROP TABLE friends_user');
    }
}
