<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241118192422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trajets (id INT AUTO_INCREMENT NOT NULL, voitures_id INT NOT NULL, conducteur_id INT NOT NULL, voiture_id INT NOT NULL, point_depart VARCHAR(255) NOT NULL, point_darrivee VARCHAR(255) NOT NULL, date_depart DATE NOT NULL, nombre_place_dispo INT NOT NULL, prix NUMERIC(10, 0) NOT NULL, INDEX IDX_FF2B5BA9CCC4661F (voitures_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trajets ADD CONSTRAINT FK_FF2B5BA9CCC4661F FOREIGN KEY (voitures_id) REFERENCES voitures (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trajets DROP FOREIGN KEY FK_FF2B5BA9CCC4661F');
        $this->addSql('DROP TABLE trajets');
    }
}
