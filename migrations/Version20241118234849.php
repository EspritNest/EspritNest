<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241118234849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonces_colocation (id INT AUTO_INCREMENT NOT NULL, logement_id INT DEFAULT NULL, maison_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, nombre_chambres INT NOT NULL, prix DOUBLE PRECISION NOT NULL, date_pub DATE NOT NULL, INDEX IDX_6BE30F9C58ABF955 (logement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussions (id INT AUTO_INCREMENT NOT NULL, utilisateur1_id INT NOT NULL, utilisateur2_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logement (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(100) NOT NULL, code_postal VARCHAR(10) DEFAULT NULL, superficie DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, date_ajout DATE NOT NULL, proprietaire_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, discussions_id INT NOT NULL, expéditeur_id INT NOT NULL, contenu VARCHAR(255) NOT NULL, date_envoi DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajets (id INT AUTO_INCREMENT NOT NULL, voitures_id INT NOT NULL, conducteur_id INT NOT NULL, voiture_id INT NOT NULL, point_depart VARCHAR(255) NOT NULL, point_darrivee VARCHAR(255) NOT NULL, date_depart DATE NOT NULL, nombre_place_dispo INT NOT NULL, prix NUMERIC(10, 0) NOT NULL, heure_depart TIME NOT NULL, INDEX IDX_FF2B5BA9CCC4661F (voitures_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voitures (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, marque VARCHAR(255) NOT NULL, couleur VARCHAR(255) NOT NULL, plaque_immatriculation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonces_colocation ADD CONSTRAINT FK_6BE30F9C58ABF955 FOREIGN KEY (logement_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE trajets ADD CONSTRAINT FK_FF2B5BA9CCC4661F FOREIGN KEY (voitures_id) REFERENCES voitures (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces_colocation DROP FOREIGN KEY FK_6BE30F9C58ABF955');
        $this->addSql('ALTER TABLE trajets DROP FOREIGN KEY FK_FF2B5BA9CCC4661F');
        $this->addSql('DROP TABLE annonces_colocation');
        $this->addSql('DROP TABLE discussions');
        $this->addSql('DROP TABLE logement');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE trajets');
        $this->addSql('DROP TABLE voitures');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
