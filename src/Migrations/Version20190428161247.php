<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190428161247 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE picture');
        $this->addSql('ALTER TABLE property ADD updated_at DATETIME NOT NULL, CHANGE complement file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP email, DROP roles, DROP reset_token');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, date DATETIME NOT NULL, participants INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, property_id INT NOT NULL, filename VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_16DB4F89549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE property DROP updated_at, CHANGE file_name complement VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user ADD email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD roles LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', ADD reset_token VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
