<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220721074519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre CHANGE type type ENUM(\'simple\', \'double\', \'supérieure\')');
        $this->addSql('ALTER TABLE photo ADD chambre_id INT NOT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784189B177F54 FOREIGN KEY (chambre_id) REFERENCES chambre (id)');
        $this->addSql('CREATE INDEX IDX_14B784189B177F54 ON photo (chambre_id)');
        $this->addSql('ALTER TABLE user CHANGE qualite qualite ENUM(\'Manager\', \'Assistant manager\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784189B177F54');
        $this->addSql('DROP INDEX IDX_14B784189B177F54 ON photo');
        $this->addSql('ALTER TABLE photo DROP chambre_id');
        $this->addSql('ALTER TABLE user CHANGE qualite qualite VARCHAR(255) DEFAULT NULL');
    }
}
