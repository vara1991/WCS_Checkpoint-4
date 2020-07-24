<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200722113215 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, start DATETIME DEFAULT NULL, end DATETIME DEFAULT NULL, place INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE performer (id INT AUTO_INCREMENT NOT NULL, picture VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, biography LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE performer_show (performer_id INT NOT NULL, show_id INT NOT NULL, INDEX IDX_DB2270946C6B33F3 (performer_id), INDEX IDX_DB227094D0C1FC64 (show_id), PRIMARY KEY(performer_id, show_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `show` (id INT AUTO_INCREMENT NOT NULL, picture VARCHAR(255) DEFAULT NULL, summary LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spectator (id INT AUTO_INCREMENT NOT NULL, booking_id INT DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, INDEX IDX_54C715053301C60 (booking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE performer_show ADD CONSTRAINT FK_DB2270946C6B33F3 FOREIGN KEY (performer_id) REFERENCES performer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE performer_show ADD CONSTRAINT FK_DB227094D0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE spectator ADD CONSTRAINT FK_54C715053301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spectator DROP FOREIGN KEY FK_54C715053301C60');
        $this->addSql('ALTER TABLE performer_show DROP FOREIGN KEY FK_DB2270946C6B33F3');
        $this->addSql('ALTER TABLE performer_show DROP FOREIGN KEY FK_DB227094D0C1FC64');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE performer');
        $this->addSql('DROP TABLE performer_show');
        $this->addSql('DROP TABLE `show`');
        $this->addSql('DROP TABLE spectator');
    }
}
