<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240312125443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sheet ADD talents JSON NOT NULL');
        $this->addSql('UPDATE sheet INNER JOIN `character` ON `character`.`id` = `sheet`.id SET `sheet`.talents = `character`.talents;');
        $this->addSql('ALTER TABLE `character` DROP talents');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` ADD talents JSON DEFAULT NULL');
        $this->addSql('UPDATE `character` INNER JOIN sheet ON `character`.`id` = `sheet`.id SET `character`.talents = `sheet`.talents;');
        $this->addSql('ALTER TABLE sheet DROP talents');
    }
}
