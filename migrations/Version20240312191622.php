<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240312191622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `pet` (
                                            id INT NOT NULL, 
                                            owner_id INT NOT NULL, 
                                            species_id INT NOT NULL, 
                                            user_id INT NOT NULL, 
                                            lore LONGTEXT DEFAULT NULL, 
                                            INDEX IDX_E4529B857E3C61F9 (owner_id), 
                                            INDEX IDX_E4529B85B2A1D860 (species_id), 
                                            INDEX IDX_E4529B85A76ED395 (user_id), 
                                            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `pet` ADD CONSTRAINT FK_E4529B857E3C61F9 FOREIGN KEY (owner_id) REFERENCES `character` (id)');
        $this->addSql('ALTER TABLE `pet` ADD CONSTRAINT FK_E4529B85B2A1D860 FOREIGN KEY (species_id) REFERENCES creature (id)');
        $this->addSql('ALTER TABLE `pet` ADD CONSTRAINT FK_E4529B85A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `pet` ADD CONSTRAINT FK_E4529B85BF396750 FOREIGN KEY (id) REFERENCES sheet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `character` DROP image, DROP slug');
        $this->addSql('ALTER TABLE sheet 
                            ADD image VARCHAR(255) DEFAULT NULL, 
                            ADD slug VARCHAR(255) DEFAULT NULL, 
                            CHANGE talents talents JSON DEFAULT NULL,
                            ADD experience INT DEFAULT NULL, 
                            ADD skills JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `pet` DROP FOREIGN KEY FK_E4529B857E3C61F9');
        $this->addSql('ALTER TABLE `pet` DROP FOREIGN KEY FK_E4529B85B2A1D860');
        $this->addSql('ALTER TABLE `pet` DROP FOREIGN KEY FK_E4529B85A76ED395');
        $this->addSql('ALTER TABLE `pet` DROP FOREIGN KEY FK_E4529B85BF396750');
        $this->addSql('DROP TABLE `pet`');
        $this->addSql('ALTER TABLE `character` ADD image VARCHAR(255) DEFAULT NULL, ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE sheet 
                            DROP image, 
                            DROP slug, 
                            CHANGE talents talents JSON NOT NULL
                            DROP experience,
                            DROP skills');
    }
}
