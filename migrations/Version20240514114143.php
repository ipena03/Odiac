<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514114143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aimer (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aimer_produit (aimer_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_23FE3EABDAC3E6F6 (aimer_id), INDEX IDX_23FE3EABF347EFB (produit_id), PRIMARY KEY(aimer_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aimer_user (aimer_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_EF711B6ADAC3E6F6 (aimer_id), INDEX IDX_EF711B6AA76ED395 (user_id), PRIMARY KEY(aimer_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE aimer_produit ADD CONSTRAINT FK_23FE3EABDAC3E6F6 FOREIGN KEY (aimer_id) REFERENCES aimer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aimer_produit ADD CONSTRAINT FK_23FE3EABF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aimer_user ADD CONSTRAINT FK_EF711B6ADAC3E6F6 FOREIGN KEY (aimer_id) REFERENCES aimer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aimer_user ADD CONSTRAINT FK_EF711B6AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aimer_produit DROP FOREIGN KEY FK_23FE3EABDAC3E6F6');
        $this->addSql('ALTER TABLE aimer_produit DROP FOREIGN KEY FK_23FE3EABF347EFB');
        $this->addSql('ALTER TABLE aimer_user DROP FOREIGN KEY FK_EF711B6ADAC3E6F6');
        $this->addSql('ALTER TABLE aimer_user DROP FOREIGN KEY FK_EF711B6AA76ED395');
        $this->addSql('DROP TABLE aimer');
        $this->addSql('DROP TABLE aimer_produit');
        $this->addSql('DROP TABLE aimer_user');
    }
}
