<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327071831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE armor_piece ADD magical_absorption INT NOT NULL, CHANGE value physical_absorption INT NOT NULL');
        $this->addSql('ALTER TABLE armor_piece_character ADD physical_absorption INT DEFAULT NULL, ADD magical_absorption INT DEFAULT NULL');
        $this->addSql('ALTER TABLE weapon_character ADD damage INT DEFAULT NULL, ADD dice VARCHAR(10) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE armor_piece ADD value INT NOT NULL, DROP physical_absorption, DROP magical_absorption');
        $this->addSql('ALTER TABLE armor_piece_character DROP physical_absorption, DROP magical_absorption');
        $this->addSql('ALTER TABLE weapon_character DROP damage, DROP dice');
    }
}
