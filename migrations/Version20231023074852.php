<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023074852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE armor_location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, var_name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE armor_piece (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, type_id INT NOT NULL, value INT NOT NULL, INDEX IDX_A841FE4B64D218E (location_id), INDEX IDX_A841FE4BC54C8C93 (type_id), UNIQUE INDEX location_type (location_id, type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE armor_piece_character (id INT NOT NULL, charact_id INT NOT NULL, piece_id INT DEFAULT NULL, effect VARCHAR(50) DEFAULT NULL, INDEX IDX_77FBAA0C39306F15 (charact_id), INDEX IDX_77FBAA0CC40FCFA8 (piece_id), PRIMARY KEY(id, charact_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE armor_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bestiary (id INT NOT NULL, type_id INT NOT NULL, note LONGTEXT DEFAULT NULL, INDEX IDX_946DE9FFC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bestiary_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `character` (id INT NOT NULL, user_id INT NOT NULL, class_id INT NOT NULL, race_id INT NOT NULL, team_id INT DEFAULT NULL, lore LONGTEXT DEFAULT NULL, inventory LONGTEXT DEFAULT NULL, gold INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, last_view DATETIME DEFAULT NULL, talents JSON DEFAULT NULL, INDEX IDX_937AB034A76ED395 (user_id), INDEX IDX_937AB034EA000B10 (class_id), INDEX IDX_937AB0346E59D40D (race_id), INDEX IDX_937AB034296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, dice_pv VARCHAR(30) NOT NULL, dice_pm VARCHAR(30) NOT NULL, dice_pc VARCHAR(30) NOT NULL, description LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE duration_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, symbol VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, description LONGTEXT NOT NULL, bonus LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, social_ability LONGTEXT NOT NULL, physical_ability LONGTEXT NOT NULL, min_height INT NOT NULL, max_height INT NOT NULL, average_wheight INT NOT NULL, adulthood INT NOT NULL, lifetime INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, symbol VARCHAR(2) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sheet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, level INT NOT NULL, pv INT NOT NULL, pv_max INT NOT NULL, pc INT NOT NULL, pc_max INT NOT NULL, pm INT NOT NULL, pm_max INT NOT NULL, constitution INT NOT NULL, strength INT NOT NULL, dexterity INT NOT NULL, intelligence INT NOT NULL, charisma INT NOT NULL, faith INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', discr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, class_id INT NOT NULL, resource_id INT DEFAULT NULL, duration_type_id INT DEFAULT NULL, dice_throw_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, level INT NOT NULL, cost INT DEFAULT NULL, distance DOUBLE PRECISION DEFAULT NULL, damage VARCHAR(10) DEFAULT NULL, radius DOUBLE PRECISION DEFAULT NULL, duration INT DEFAULT NULL, experience INT NOT NULL, INDEX IDX_5E3DE477EA000B10 (class_id), INDEX IDX_5E3DE47789329D25 (resource_id), INDEX IDX_5E3DE47780CA3F3B (duration_type_id), INDEX IDX_5E3DE47785F544C0 (dice_throw_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statistic (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, symbol VARCHAR(10) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE talent (id INT AUTO_INCREMENT NOT NULL, statistic_id INT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_16D902F553B6268F (statistic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, master_id INT NOT NULL, name VARCHAR(50) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_C4E0A61F13B3DB11 (master_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(30) NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6495E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weapon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, damage INT NOT NULL, dice VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weapon_character (id INT NOT NULL, charact_id INT NOT NULL, weapon_id INT DEFAULT NULL, effect VARCHAR(50) DEFAULT NULL, INDEX IDX_71B3DE9239306F15 (charact_id), INDEX IDX_71B3DE9295B82273 (weapon_id), PRIMARY KEY(id, charact_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE armor_piece ADD CONSTRAINT FK_A841FE4B64D218E FOREIGN KEY (location_id) REFERENCES armor_location (id)');
        $this->addSql('ALTER TABLE armor_piece ADD CONSTRAINT FK_A841FE4BC54C8C93 FOREIGN KEY (type_id) REFERENCES armor_type (id)');
        $this->addSql('ALTER TABLE armor_piece_character ADD CONSTRAINT FK_77FBAA0C39306F15 FOREIGN KEY (charact_id) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE armor_piece_character ADD CONSTRAINT FK_77FBAA0CC40FCFA8 FOREIGN KEY (piece_id) REFERENCES armor_piece (id)');
        $this->addSql('ALTER TABLE bestiary ADD CONSTRAINT FK_946DE9FFC54C8C93 FOREIGN KEY (type_id) REFERENCES bestiary_type (id)');
        $this->addSql('ALTER TABLE bestiary ADD CONSTRAINT FK_946DE9FFBF396750 FOREIGN KEY (id) REFERENCES sheet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB034A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB034EA000B10 FOREIGN KEY (class_id) REFERENCES classes (id)');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB0346E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB034296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB034BF396750 FOREIGN KEY (id) REFERENCES sheet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477EA000B10 FOREIGN KEY (class_id) REFERENCES classes (id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE47789329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE47780CA3F3B FOREIGN KEY (duration_type_id) REFERENCES duration_type (id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE47785F544C0 FOREIGN KEY (dice_throw_id) REFERENCES statistic (id)');
        $this->addSql('ALTER TABLE talent ADD CONSTRAINT FK_16D902F553B6268F FOREIGN KEY (statistic_id) REFERENCES statistic (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F13B3DB11 FOREIGN KEY (master_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE weapon_character ADD CONSTRAINT FK_71B3DE9239306F15 FOREIGN KEY (charact_id) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE weapon_character ADD CONSTRAINT FK_71B3DE9295B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE armor_piece DROP FOREIGN KEY FK_A841FE4B64D218E');
        $this->addSql('ALTER TABLE armor_piece DROP FOREIGN KEY FK_A841FE4BC54C8C93');
        $this->addSql('ALTER TABLE armor_piece_character DROP FOREIGN KEY FK_77FBAA0C39306F15');
        $this->addSql('ALTER TABLE armor_piece_character DROP FOREIGN KEY FK_77FBAA0CC40FCFA8');
        $this->addSql('ALTER TABLE bestiary DROP FOREIGN KEY FK_946DE9FFC54C8C93');
        $this->addSql('ALTER TABLE bestiary DROP FOREIGN KEY FK_946DE9FFBF396750');
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB034A76ED395');
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB034EA000B10');
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB0346E59D40D');
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB034296CD8AE');
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB034BF396750');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477EA000B10');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE47789329D25');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE47780CA3F3B');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE47785F544C0');
        $this->addSql('ALTER TABLE talent DROP FOREIGN KEY FK_16D902F553B6268F');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F13B3DB11');
        $this->addSql('ALTER TABLE weapon_character DROP FOREIGN KEY FK_71B3DE9239306F15');
        $this->addSql('ALTER TABLE weapon_character DROP FOREIGN KEY FK_71B3DE9295B82273');
        $this->addSql('DROP TABLE armor_location');
        $this->addSql('DROP TABLE armor_piece');
        $this->addSql('DROP TABLE armor_piece_character');
        $this->addSql('DROP TABLE armor_type');
        $this->addSql('DROP TABLE bestiary');
        $this->addSql('DROP TABLE bestiary_type');
        $this->addSql('DROP TABLE `character`');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE duration_type');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE resource');
        $this->addSql('DROP TABLE sheet');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE statistic');
        $this->addSql('DROP TABLE talent');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE weapon');
        $this->addSql('DROP TABLE weapon_character');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
