<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201204000450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE account_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE interaction_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE interaction_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE interaction_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lead_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lead_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE opportunity_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE opportunity_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sale_phase_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_role_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE account (id INT NOT NULL, assigned_to_id INT NOT NULL, account_name VARCHAR(255) NOT NULL, billing_city VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, office_phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7D3656A4F4BD7827 ON account (assigned_to_id)');
        $this->addSql('CREATE TABLE contact (id INT NOT NULL, assigned_to_id INT NOT NULL, account_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, function VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4C62E638F4BD7827 ON contact (assigned_to_id)');
        $this->addSql('CREATE INDEX IDX_4C62E6389B6B5FBA ON contact (account_id)');
        $this->addSql('CREATE TABLE interaction (id INT NOT NULL, assigned_to_id INT DEFAULT NULL, account_id INT DEFAULT NULL, status_id INT NOT NULL, type_id INT NOT NULL, created_date DATE DEFAULT NULL, date_due DATE DEFAULT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_378DFDA7F4BD7827 ON interaction (assigned_to_id)');
        $this->addSql('CREATE INDEX IDX_378DFDA79B6B5FBA ON interaction (account_id)');
        $this->addSql('CREATE INDEX IDX_378DFDA76BF700BD ON interaction (status_id)');
        $this->addSql('CREATE INDEX IDX_378DFDA7C54C8C93 ON interaction (type_id)');
        $this->addSql('CREATE TABLE interaction_status (id INT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE interaction_type (id INT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE lead (id INT NOT NULL, assigned_to_id INT NOT NULL, status_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, website VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, industry VARCHAR(255) DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, zipcode INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_289161CBF4BD7827 ON lead (assigned_to_id)');
        $this->addSql('CREATE INDEX IDX_289161CB6BF700BD ON lead (status_id)');
        $this->addSql('CREATE TABLE lead_status (id INT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE opportunity (id INT NOT NULL, assigned_to_id INT DEFAULT NULL, account_id INT DEFAULT NULL, status_id INT DEFAULT NULL, lead_id INT NOT NULL, amount DOUBLE PRECISION DEFAULT NULL, date_due DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8389C3D7F4BD7827 ON opportunity (assigned_to_id)');
        $this->addSql('CREATE INDEX IDX_8389C3D79B6B5FBA ON opportunity (account_id)');
        $this->addSql('CREATE INDEX IDX_8389C3D76BF700BD ON opportunity (status_id)');
        $this->addSql('CREATE INDEX IDX_8389C3D755458D ON opportunity (lead_id)');
        $this->addSql('CREATE TABLE opportunity_status (id INT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE sale_phase (id INT NOT NULL, opportunity_id INT NOT NULL, phase VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_61618E489A34590F ON sale_phase (opportunity_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, status_id INT NOT NULL, user_role_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE INDEX IDX_8D93D6496BF700BD ON "user" (status_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6498E0E3CA6 ON "user" (user_role_id)');
        $this->addSql('CREATE TABLE user_role (id INT NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_status (id INT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4F4BD7827 FOREIGN KEY (assigned_to_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638F4BD7827 FOREIGN KEY (assigned_to_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6389B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA7F4BD7827 FOREIGN KEY (assigned_to_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA79B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA76BF700BD FOREIGN KEY (status_id) REFERENCES interaction_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA7C54C8C93 FOREIGN KEY (type_id) REFERENCES interaction_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lead ADD CONSTRAINT FK_289161CBF4BD7827 FOREIGN KEY (assigned_to_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lead ADD CONSTRAINT FK_289161CB6BF700BD FOREIGN KEY (status_id) REFERENCES lead_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7F4BD7827 FOREIGN KEY (assigned_to_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D79B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D76BF700BD FOREIGN KEY (status_id) REFERENCES opportunity_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D755458D FOREIGN KEY (lead_id) REFERENCES lead (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sale_phase ADD CONSTRAINT FK_61618E489A34590F FOREIGN KEY (opportunity_id) REFERENCES opportunity (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6496BF700BD FOREIGN KEY (status_id) REFERENCES user_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6498E0E3CA6 FOREIGN KEY (user_role_id) REFERENCES user_role (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE contact DROP CONSTRAINT FK_4C62E6389B6B5FBA');
        $this->addSql('ALTER TABLE interaction DROP CONSTRAINT FK_378DFDA79B6B5FBA');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT FK_8389C3D79B6B5FBA');
        $this->addSql('ALTER TABLE interaction DROP CONSTRAINT FK_378DFDA76BF700BD');
        $this->addSql('ALTER TABLE interaction DROP CONSTRAINT FK_378DFDA7C54C8C93');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT FK_8389C3D755458D');
        $this->addSql('ALTER TABLE lead DROP CONSTRAINT FK_289161CB6BF700BD');
        $this->addSql('ALTER TABLE sale_phase DROP CONSTRAINT FK_61618E489A34590F');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT FK_8389C3D76BF700BD');
        $this->addSql('ALTER TABLE account DROP CONSTRAINT FK_7D3656A4F4BD7827');
        $this->addSql('ALTER TABLE contact DROP CONSTRAINT FK_4C62E638F4BD7827');
        $this->addSql('ALTER TABLE interaction DROP CONSTRAINT FK_378DFDA7F4BD7827');
        $this->addSql('ALTER TABLE lead DROP CONSTRAINT FK_289161CBF4BD7827');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT FK_8389C3D7F4BD7827');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6498E0E3CA6');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6496BF700BD');
        $this->addSql('DROP SEQUENCE account_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contact_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE interaction_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE interaction_status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE interaction_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE lead_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE lead_status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE opportunity_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE opportunity_status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sale_phase_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE user_role_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_status_id_seq CASCADE');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE interaction');
        $this->addSql('DROP TABLE interaction_status');
        $this->addSql('DROP TABLE interaction_type');
        $this->addSql('DROP TABLE lead');
        $this->addSql('DROP TABLE lead_status');
        $this->addSql('DROP TABLE opportunity');
        $this->addSql('DROP TABLE opportunity_status');
        $this->addSql('DROP TABLE sale_phase');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP TABLE user_status');
    }
}
