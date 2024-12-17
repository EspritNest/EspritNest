<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241214164011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonces_colocation (id INT AUTO_INCREMENT NOT NULL, logement_id INT DEFAULT NULL, user_id_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, nombre_chambres INT NOT NULL, prix DOUBLE PRECISION NOT NULL, date_pub DATE NOT NULL, INDEX IDX_6BE30F9C58ABF955 (logement_id), INDEX IDX_6BE30F9C9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, log_id INT DEFAULT NULL, user_id INT DEFAULT NULL, commentt VARCHAR(255) NOT NULL, date_c DATETIME NOT NULL, INDEX IDX_9474526CEA675D86 (log_id), INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussions (id INT AUTO_INCREMENT NOT NULL, participant1_id INT NOT NULL, participant2_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8B716B63B29A9963 (participant1_id), INDEX IDX_8B716B63A02F368D (participant2_id), UNIQUE INDEX unique_participants (participant1_id, participant2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logement (id INT AUTO_INCREMENT NOT NULL, proprietaire_id_id INT NOT NULL, adresse VARCHAR(100) NOT NULL, code_postal VARCHAR(10) DEFAULT NULL, superficie DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, date_ajout DATE NOT NULL, INDEX IDX_F0FD44576EC1D6E1 (proprietaire_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, discussion_id INT NOT NULL, content LONGTEXT NOT NULL, sent_at DATETIME NOT NULL, INDEX IDX_DB021E96F624B39D (sender_id), INDEX IDX_DB021E961ADED311 (discussion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajets (id INT AUTO_INCREMENT NOT NULL, voitures_id INT NOT NULL, conducteur_id INT NOT NULL, voiture_id INT NOT NULL, point_depart VARCHAR(255) NOT NULL, point_darrivee VARCHAR(255) NOT NULL, date_depart DATE NOT NULL, nombre_place_dispo INT NOT NULL, prix NUMERIC(10, 0) NOT NULL, heure_depart TIME NOT NULL, INDEX IDX_FF2B5BA9CCC4661F (voitures_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', tel INT NOT NULL, img VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, verification_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voitures (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, marque VARCHAR(255) NOT NULL, couleur VARCHAR(255) NOT NULL, plaque_immatriculation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonces_colocation ADD CONSTRAINT FK_6BE30F9C58ABF955 FOREIGN KEY (logement_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE annonces_colocation ADD CONSTRAINT FK_6BE30F9C9D86650F FOREIGN KEY (user_id_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CEA675D86 FOREIGN KEY (log_id) REFERENCES annonces_colocation (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE discussions ADD CONSTRAINT FK_8B716B63B29A9963 FOREIGN KEY (participant1_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE discussions ADD CONSTRAINT FK_8B716B63A02F368D FOREIGN KEY (participant2_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE logement ADD CONSTRAINT FK_F0FD44576EC1D6E1 FOREIGN KEY (proprietaire_id_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96F624B39D FOREIGN KEY (sender_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E961ADED311 FOREIGN KEY (discussion_id) REFERENCES discussions (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE trajets ADD CONSTRAINT FK_FF2B5BA9CCC4661F FOREIGN KEY (voitures_id) REFERENCES voitures (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces_colocation DROP FOREIGN KEY FK_6BE30F9C58ABF955');
        $this->addSql('ALTER TABLE annonces_colocation DROP FOREIGN KEY FK_6BE30F9C9D86650F');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CEA675D86');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE discussions DROP FOREIGN KEY FK_8B716B63B29A9963');
        $this->addSql('ALTER TABLE discussions DROP FOREIGN KEY FK_8B716B63A02F368D');
        $this->addSql('ALTER TABLE logement DROP FOREIGN KEY FK_F0FD44576EC1D6E1');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96F624B39D');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E961ADED311');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE trajets DROP FOREIGN KEY FK_FF2B5BA9CCC4661F');
        $this->addSql('DROP TABLE annonces_colocation');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE discussions');
        $this->addSql('DROP TABLE logement');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE trajets');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE voitures');
    }
}
