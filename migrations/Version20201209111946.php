<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201209111946 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE interaction ADD contact_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA7E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_378DFDA7E7A1254A ON interaction (contact_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE interaction DROP CONSTRAINT FK_378DFDA7E7A1254A');
        $this->addSql('DROP INDEX IDX_378DFDA7E7A1254A');
        $this->addSql('ALTER TABLE interaction DROP contact_id');
    }
}
