<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240312123530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bestiary_type RENAME TO creature_type;');
        $this->addSql('ALTER TABLE bestiary RENAME TO creature;');
        $this->addSql('ALTER TABLE creature ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE creature RENAME INDEX idx_946de9ffc54c8c93 TO IDX_2A6C6AF4C54C8C93');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creature_type RENAME TO bestiary_type;');
        $this->addSql('ALTER TABLE creature RENAME TO bestiary;');
        $this->addSql('ALTER TABLE creature DROP description');
        $this->addSql('ALTER TABLE creature RENAME INDEX idx_2a6c6af4c54c8c93 TO IDX_946DE9FFC54C8C93');
    }
}
