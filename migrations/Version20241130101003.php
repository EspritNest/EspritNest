<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241130101003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trajets (id INT AUTO_INCREMENT NOT NULL, voitures_id INT NOT NULL, conducteur_id INT NOT NULL, voiture_id INT NOT NULL, point_depart VARCHAR(255) NOT NULL, point_darrivee VARCHAR(255) NOT NULL, date_depart DATE NOT NULL, nombre_place_dispo INT NOT NULL, prix NUMERIC(10, 0) NOT NULL, heure_depart TIME NOT NULL, INDEX IDX_FF2B5BA9CCC4661F (voitures_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', tel INT NOT NULL, img VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voitures (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, marque VARCHAR(255) NOT NULL, couleur VARCHAR(255) NOT NULL, plaque_immatriculation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trajets ADD CONSTRAINT FK_FF2B5BA9CCC4661F FOREIGN KEY (voitures_id) REFERENCES voitures (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trajets DROP FOREIGN KEY FK_FF2B5BA9CCC4661F');
        $this->addSql('DROP TABLE trajets');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE voitures');
    }
}
