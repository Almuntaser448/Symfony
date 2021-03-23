<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201020060606 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facturation (id INT AUTO_INCREMENT NOT NULL, ide_id INT NOT NULL, idv_id INT NOT NULL, date_d DATETIME NOT NULL, date_f DATETIME NOT NULL, valeur INT NOT NULL, etat VARCHAR(255) NOT NULL, INDEX IDX_17EB513A677335AF (ide_id), UNIQUE INDEX UNIQ_17EB513A25DFCDDE (idv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, type INT NOT NULL, nb INT NOT NULL, caract LONGTEXT NOT NULL, location VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facturation ADD CONSTRAINT FK_17EB513A677335AF FOREIGN KEY (ide_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE facturation ADD CONSTRAINT FK_17EB513A25DFCDDE FOREIGN KEY (idv_id) REFERENCES vehicule (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facturation DROP FOREIGN KEY FK_17EB513A677335AF');
        $this->addSql('ALTER TABLE facturation DROP FOREIGN KEY FK_17EB513A25DFCDDE');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE facturation');
        $this->addSql('DROP TABLE vehicule');
    }
}
