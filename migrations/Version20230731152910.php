<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230731152910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity_squad (activity_id INT NOT NULL, squad_id INT NOT NULL, INDEX IDX_D1D2C95481C06096 (activity_id), INDEX IDX_D1D2C954DF1B2C7C (squad_id), PRIMARY KEY(activity_id, squad_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE squad (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE squad_user (squad_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_55AC45DDDF1B2C7C (squad_id), INDEX IDX_55AC45DDA76ED395 (user_id), PRIMARY KEY(squad_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity_squad ADD CONSTRAINT FK_D1D2C95481C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_squad ADD CONSTRAINT FK_D1D2C954DF1B2C7C FOREIGN KEY (squad_id) REFERENCES squad (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE squad_user ADD CONSTRAINT FK_55AC45DDDF1B2C7C FOREIGN KEY (squad_id) REFERENCES squad (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE squad_user ADD CONSTRAINT FK_55AC45DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity_squad DROP FOREIGN KEY FK_D1D2C95481C06096');
        $this->addSql('ALTER TABLE activity_squad DROP FOREIGN KEY FK_D1D2C954DF1B2C7C');
        $this->addSql('ALTER TABLE squad_user DROP FOREIGN KEY FK_55AC45DDDF1B2C7C');
        $this->addSql('ALTER TABLE squad_user DROP FOREIGN KEY FK_55AC45DDA76ED395');
        $this->addSql('DROP TABLE activity_squad');
        $this->addSql('DROP TABLE squad');
        $this->addSql('DROP TABLE squad_user');
    }
}
