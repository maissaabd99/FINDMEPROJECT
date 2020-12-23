<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201222195618 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE conversation ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9642B8210 FOREIGN KEY (admin_id) REFERENCES administration (id)');
        $this->addSql('CREATE INDEX IDX_8A8E26E9642B8210 ON conversation (admin_id)');
        $this->addSql('ALTER TABLE publication ADD archiver TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur CHANGE bloque bloque TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9642B8210');
        $this->addSql('DROP INDEX IDX_8A8E26E9642B8210 ON conversation');
        $this->addSql('ALTER TABLE conversation DROP admin_id');
        $this->addSql('ALTER TABLE publication DROP archiver');
        $this->addSql('ALTER TABLE utilisateur CHANGE bloque bloque VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
