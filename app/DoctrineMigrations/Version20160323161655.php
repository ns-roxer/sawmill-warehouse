<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160323161655 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Plank (id INT AUTO_INCREMENT NOT NULL, color_id INT NOT NULL, material_id INT NOT NULL, length DOUBLE PRECISION NOT NULL, height DOUBLE PRECISION NOT NULL, width DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, INDEX IDX_E7CA2F837ADA1FB5 (color_id), INDEX IDX_E7CA2F83E308AC6F (material_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, UNIQUE INDEX UNIQ_A79767ED5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Material (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, UNIQUE INDEX UNIQ_85C817C35E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Plank ADD CONSTRAINT FK_E7CA2F837ADA1FB5 FOREIGN KEY (color_id) REFERENCES Color (id)');
        $this->addSql('ALTER TABLE Plank ADD CONSTRAINT FK_E7CA2F83E308AC6F FOREIGN KEY (material_id) REFERENCES Material (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Plank DROP FOREIGN KEY FK_E7CA2F837ADA1FB5');
        $this->addSql('ALTER TABLE Plank DROP FOREIGN KEY FK_E7CA2F83E308AC6F');
        $this->addSql('DROP TABLE Plank');
        $this->addSql('DROP TABLE Color');
        $this->addSql('DROP TABLE Material');
    }
}
