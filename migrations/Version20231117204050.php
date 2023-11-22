<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231117204050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Init DB by Already Existing Entities';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, place VARCHAR(255) NOT NULL, price INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_AC74095A12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_squad (activity_id INT NOT NULL, squad_id INT NOT NULL, INDEX IDX_D1D2C95481C06096 (activity_id), INDEX IDX_D1D2C954DF1B2C7C (squad_id), PRIMARY KEY(activity_id, squad_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, pict VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE friends (id INT AUTO_INCREMENT NOT NULL, friendship_start DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE friends_user (friends_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_48FBBB49CA8337 (friends_id), INDEX IDX_48FBBBA76ED395 (user_id), PRIMARY KEY(friends_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE squad (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE squad_user (squad_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_55AC45DDDF1B2C7C (squad_id), INDEX IDX_55AC45DDA76ED395 (user_id), PRIMARY KEY(squad_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE activity_squad ADD CONSTRAINT FK_D1D2C95481C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_squad ADD CONSTRAINT FK_D1D2C954DF1B2C7C FOREIGN KEY (squad_id) REFERENCES squad (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE friends_user ADD CONSTRAINT FK_48FBBB49CA8337 FOREIGN KEY (friends_id) REFERENCES friends (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE friends_user ADD CONSTRAINT FK_48FBBBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE squad_user ADD CONSTRAINT FK_55AC45DDDF1B2C7C FOREIGN KEY (squad_id) REFERENCES squad (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE squad_user ADD CONSTRAINT FK_55AC45DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD phone_number VARCHAR(255) NOT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A12469DE2');
        $this->addSql('ALTER TABLE activity_squad DROP FOREIGN KEY FK_D1D2C95481C06096');
        $this->addSql('ALTER TABLE activity_squad DROP FOREIGN KEY FK_D1D2C954DF1B2C7C');
        $this->addSql('ALTER TABLE friends_user DROP FOREIGN KEY FK_48FBBB49CA8337');
        $this->addSql('ALTER TABLE friends_user DROP FOREIGN KEY FK_48FBBBA76ED395');
        $this->addSql('ALTER TABLE squad_user DROP FOREIGN KEY FK_55AC45DDDF1B2C7C');
        $this->addSql('ALTER TABLE squad_user DROP FOREIGN KEY FK_55AC45DDA76ED395');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE activity_squad');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE friends');
        $this->addSql('DROP TABLE friends_user');
        $this->addSql('DROP TABLE squad');
        $this->addSql('DROP TABLE squad_user');
        $this->addSql('ALTER TABLE user DROP is_verified, DROP nom, DROP prenom, DROP phone_number, CHANGE roles roles JSON NOT NULL');
    }
}
