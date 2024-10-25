<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241025174911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hopital DROP FOREIGN KEY FK_8718F2C4F31A84');
        $this->addSql('DROP INDEX IDX_8718F2C4F31A84 ON hopital');
        $this->addSql('ALTER TABLE hopital DROP medecin_id');
        $this->addSql('ALTER TABLE medecin ADD hopital_id INT NOT NULL, CHANGE date_naissance date_naissance DATE NOT NULL');
        $this->addSql('ALTER TABLE medecin ADD CONSTRAINT FK_1BDA53C6CC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id)');
        $this->addSql('CREATE INDEX IDX_1BDA53C6CC0FBF92 ON medecin (hopital_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hopital ADD medecin_id INT NOT NULL');
        $this->addSql('ALTER TABLE hopital ADD CONSTRAINT FK_8718F2C4F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('CREATE INDEX IDX_8718F2C4F31A84 ON hopital (medecin_id)');
        $this->addSql('ALTER TABLE medecin DROP FOREIGN KEY FK_1BDA53C6CC0FBF92');
        $this->addSql('DROP INDEX IDX_1BDA53C6CC0FBF92 ON medecin');
        $this->addSql('ALTER TABLE medecin DROP hopital_id, CHANGE date_naissance date_naissance DATETIME NOT NULL');
    }
}
