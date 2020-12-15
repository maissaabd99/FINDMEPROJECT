<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201207184643 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE administration CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE etat etat VARCHAR(1) DEFAULT NULL, CHANGE username username VARCHAR(255) DEFAULT NULL, CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL, CHANGE tel tel VARCHAR(255) DEFAULT NULL, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL, CHANGE bloque bloque VARCHAR(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL, CHANGE publication_id publication_id INT DEFAULT NULL, CHANGE admin_id admin_id INT DEFAULT NULL, CHANGE date_comnt date_comnt DATETIME DEFAULT NULL, CHANGE contenu_comnt contenu_comnt VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE conversation CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message CHANGE admin_id admin_id INT DEFAULT NULL, CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL, CHANGE conversation_id conversation_id INT DEFAULT NULL, CHANGE message message VARCHAR(255) DEFAULT NULL, CHANGE date_mess date_mess DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE mutimedia CHANGE publication_id publication_id INT DEFAULT NULL, CHANGE source source VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE publication ADD nom VARCHAR(255) DEFAULT NULL, DROP non, CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL, CHANGE admin_id admin_id INT DEFAULT NULL, CHANGE date_pub date_pub DATETIME DEFAULT NULL, CHANGE contenu_pub contenu_pub VARCHAR(200) DEFAULT NULL, CHANGE statut statut VARCHAR(1) DEFAULT NULL, CHANGE age age INT DEFAULT NULL, CHANGE sexe sexe VARCHAR(10) DEFAULT NULL, CHANGE localisation localisation VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL, CHANGE tel tel VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE username username VARCHAR(255) DEFAULT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE bloque bloque VARCHAR(255) DEFAULT NULL, CHANGE verified verified VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE administration CHANGE password password VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE etat etat VARCHAR(1) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE username username VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE nom nom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE prenom prenom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE tel tel VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE adresse adresse VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE bloque bloque VARCHAR(1) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE commentaire CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL, CHANGE publication_id publication_id INT DEFAULT NULL, CHANGE admin_id admin_id INT DEFAULT NULL, CHANGE date_comnt date_comnt DATETIME DEFAULT \'NULL\', CHANGE contenu_comnt contenu_comnt VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE conversation CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message CHANGE admin_id admin_id INT DEFAULT NULL, CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL, CHANGE conversation_id conversation_id INT DEFAULT NULL, CHANGE message message VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE date_mess date_mess DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE mutimedia CHANGE publication_id publication_id INT DEFAULT NULL, CHANGE source source VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE publication ADD non VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, DROP nom, CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL, CHANGE admin_id admin_id INT DEFAULT NULL, CHANGE date_pub date_pub DATETIME DEFAULT \'NULL\', CHANGE contenu_pub contenu_pub VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE statut statut VARCHAR(1) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE age age INT DEFAULT NULL, CHANGE sexe sexe VARCHAR(1) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE localisation localisation VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE utilisateur CHANGE nom nom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE prenom prenom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE adresse adresse VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE tel tel VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE username username VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE password password VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE bloque bloque VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE verified verified VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
