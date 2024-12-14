<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209210950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logement DROP INDEX UNIQ_F0FD44576EC1D6E1, ADD INDEX IDX_F0FD44576EC1D6E1 (proprietaire_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logement DROP INDEX IDX_F0FD44576EC1D6E1, ADD UNIQUE INDEX UNIQ_F0FD44576EC1D6E1 (proprietaire_id_id)');
    }
}
