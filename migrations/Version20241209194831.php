<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209194831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces_colocation ADD logement_id INT DEFAULT NULL, ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonces_colocation ADD CONSTRAINT FK_6BE30F9C58ABF955 FOREIGN KEY (logement_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE annonces_colocation ADD CONSTRAINT FK_6BE30F9C9D86650F FOREIGN KEY (user_id_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_6BE30F9C58ABF955 ON annonces_colocation (logement_id)');
        $this->addSql('CREATE INDEX IDX_6BE30F9C9D86650F ON annonces_colocation (user_id_id)');
        $this->addSql('ALTER TABLE logement CHANGE propriétaire_id proprietaire_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE logement ADD CONSTRAINT FK_F0FD44576EC1D6E1 FOREIGN KEY (proprietaire_id_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F0FD44576EC1D6E1 ON logement (proprietaire_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logement DROP FOREIGN KEY FK_F0FD44576EC1D6E1');
        $this->addSql('DROP INDEX UNIQ_F0FD44576EC1D6E1 ON logement');
        $this->addSql('ALTER TABLE logement CHANGE proprietaire_id_id propriétaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonces_colocation DROP FOREIGN KEY FK_6BE30F9C58ABF955');
        $this->addSql('ALTER TABLE annonces_colocation DROP FOREIGN KEY FK_6BE30F9C9D86650F');
        $this->addSql('DROP INDEX IDX_6BE30F9C58ABF955 ON annonces_colocation');
        $this->addSql('DROP INDEX IDX_6BE30F9C9D86650F ON annonces_colocation');
        $this->addSql('ALTER TABLE annonces_colocation DROP logement_id, DROP user_id_id');
    }
}
