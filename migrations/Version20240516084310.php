<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516084310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inserer (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, panier_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_F2C21680F347EFB (produit_id), INDEX IDX_F2C21680F77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inserer ADD CONSTRAINT FK_F2C21680F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE inserer ADD CONSTRAINT FK_F2C21680F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2A76ED395');
        $this->addSql('DROP INDEX UNIQ_24CC0DF2A76ED395 ON panier');
        $this->addSql('ALTER TABLE panier DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inserer DROP FOREIGN KEY FK_F2C21680F347EFB');
        $this->addSql('ALTER TABLE inserer DROP FOREIGN KEY FK_F2C21680F77D927C');
        $this->addSql('DROP TABLE inserer');
        $this->addSql('ALTER TABLE panier ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24CC0DF2A76ED395 ON panier (user_id)');
    }
}
